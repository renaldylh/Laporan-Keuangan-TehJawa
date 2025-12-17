<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Constants\MenuCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class SalesController extends Controller
{
    /**
     * Display the POS sales page with menu items
     */
    public function index()
    {
        // Optimize: Only select necessary columns
        $menuItems = MenuItem::select('id', 'name', 'price', 'category', 'description', 'stock', 'image', 'is_available')
            ->orderBy('category')
            ->orderBy('name')
            ->get();

        $categories = $menuItems->pluck('category')->unique()->filter()->values();
        $categoryLabels = MenuCategory::all();
        $uncategorizedCount = $menuItems->whereNull('category')->count();
        $placeholderImage = asset('images/menu-placeholder.svg');

        return view('sales.index', compact(
            'menuItems',
            'categories',
            'categoryLabels',
            'uncategorizedCount',
            'placeholderImage'
        ));
    }

    /**
     * Process sale transaction
     */
    public function store(Request $request)
    {
        try {
            // Log request awal
            \Log::info('Sales store request received', [
                'has_items' => $request->has('items'),
                'items_raw' => $request->input('items'),
                'all_request_keys' => array_keys($request->all())
            ]);

            // Pastikan data items berupa array (decode JSON dari FormData)
            $itemsRaw = $request->input('items');
            if (is_string($itemsRaw)) {
                $decodedItems = json_decode($itemsRaw, true);
                if (json_last_error() !== JSON_ERROR_NONE || !is_array($decodedItems)) {
                    \Log::error('Sales store invalid items JSON', [
                        'items_raw' => $itemsRaw,
                        'json_error' => json_last_error_msg()
                    ]);
                    throw new \Exception('Format data item tidak valid. Mohon ulangi transaksi.');
                }
                $request->merge(['items' => $decodedItems]);
            }

            // Validasi input dengan error handling
            $validated = $request->validate([
                'items' => 'required|array|min:1',
                'items.*.menu_item_id' => 'required|exists:menu_items,id',
                'items.*.quantity' => 'required|integer|min:1',
                'items.*.notes' => 'nullable|string|max:255',
                'transaction_date' => 'required|date',
                'payment_method' => 'required|string|max:50',
                'notes' => 'nullable|string|max:500',
                'receipt' => 'nullable|file|mimes:jpeg,jpg,png,pdf|max:2048',
            ], [
                'items.required' => 'Item produk wajib dipilih',
                'items.min' => 'Minimal harus ada 1 item',
                'transaction_date.required' => 'Tanggal transaksi wajib diisi',
                'payment_method.required' => 'Metode pembayaran wajib dipilih',
            ]);

            // Mulai transaksi database
            DB::beginTransaction();

            $totalAmount = 0;
            $transactionItems = [];

            // Parse items dari JSON string jika perlu
            $itemsData = $validated['items'];

            foreach ($itemsData as $item) {
                $menuItem = MenuItem::find($item['menu_item_id']);
                
                if (!$menuItem) {
                    throw new \Exception("Menu item dengan ID {$item['menu_item_id']} tidak ditemukan");
                }
                
                // Check stock availability
                if (!$menuItem->isInStock()) {
                    throw new \Exception("Stok {$menuItem->name} tidak mencukupi");
                }

                $quantity = (int)$item['quantity'];
                $unitPrice = (float)$menuItem->price;
                $totalPrice = $quantity * $unitPrice;

                $totalAmount += $totalPrice;

                $transactionItems[] = [
                    'menu_item_id' => $menuItem->id,
                    'menu_name' => $menuItem->name,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'total_price' => $totalPrice,
                    'notes' => $item['notes'] ?? null,
                    'created_at' => now(),
                    'updated_at' => now()
                ];

                // Update stock if not unlimited
                if ($menuItem->stock != -1) {
                    $menuItem->decrement('stock', $quantity);
                }
            }

            if ($totalAmount <= 0) {
                throw new \Exception("Total transaksi tidak valid: Rp 0");
            }

            // Buat deskripsi transaksi
            $description = 'Transaksi Lain - Penjualan Menu';
            if (!empty($validated['notes'])) {
                $description .= ' - ' . $validated['notes'];
            }
            $description .= ' (' . count($itemsData) . ' item)';

            // Handle receipt upload
            $receiptPath = null;
            $receiptFilename = null;
            if (isset($validated['receipt']) && $validated['receipt']) {
                $receiptFile = $validated['receipt'];
                $receiptFilename = time() . '_' . $receiptFile->getClientOriginalName();
                $receiptPath = $receiptFile->storeAs('receipts', $receiptFilename, 'public');
            }

            // Simpan transaksi sebagai TRANSAKSI LAIN (Pemasukan Lain)
            $transaction = Auth::user()->transactions()->create([
                'transaction_date' => $validated['transaction_date'],
                'amount' => $totalAmount,
                'description' => $description,
                'type' => 'income_other', // Transaksi Lain - Pemasukan
                'payment_method' => $validated['payment_method'],
                'receipt_path' => $receiptPath,
                'receipt_filename' => $receiptFilename,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            \Log::info('Transaction created', [
                'transaction_id' => $transaction->id,
                'type' => $transaction->type,
                'amount' => $transaction->amount,
                'description' => $transaction->description
            ]);

            // Simpan detail transaksi
            if (!empty($transactionItems)) {
                $transaction->transactionDetails()->createMany($transactionItems);
                \Log::info('Transaction details created', ['count' => count($transactionItems)]);
            }

            // Commit transaksi
            DB::commit();

            \Log::info('Transaction committed successfully');

            // Respon untuk AJAX
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => "Transaksi lain berhasil disimpan ke pemasukan!",
                    'transaction_id' => $transaction->id,
                    'total_amount' => $totalAmount,
                    'type' => 'income_other',
                    'description' => $description,
                    'transaction_date' => $transaction->transaction_date,
                    'payment_method' => $transaction->payment_method
                ]);
            }

            return redirect()->route('transactions.index')
                ->with('success', "Transaksi berhasil disimpan! Total: Rp " . number_format($totalAmount, 0, ',', '.'));

        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi error
            DB::rollBack();
            Log::error('Error in SalesController@store: ' . $e->getMessage());
            Log::error($e->getTraceAsString());

            $errorMessage = 'Terjadi kesalahan saat menyimpan transaksi. ' . $e->getMessage();
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $errorMessage
                ], 500);
            }

            return back()->withErrors(['error' => $errorMessage])->withInput();
        }
    }

    /**
     * Quick sale API for POS
     */
    public function quickSale(Request $request)
    {
        $validated = $request->validate([
            'menu_item_id' => 'required|exists:menu_items,id',
            'quantity' => 'required|integer|min:1',
            'payment_method' => 'required|string|max:50',
        ]);

        $menuItem = MenuItem::find($validated['menu_item_id']);
        if (!$menuItem || !$menuItem->isInStock()) {
            return response()->json(['error' => 'Menu tidak tersedia'], 400);
        }

        $totalPrice = $menuItem->price * $validated['quantity'];

        $transaction = Auth::user()->transactions()->create([
            'transaction_date' => now(),
            'amount' => $totalPrice,
            'description' => "Transaksi Lain - Quick Sale: {$menuItem->name} ({$validated['quantity']}x)",
            'type' => 'income_other',
            'payment_method' => $validated['payment_method'],
        ]);

        $transaction->transactionDetails()->create([
            'menu_item_id' => $menuItem->id,
            'menu_name' => $menuItem->name,
            'quantity' => $validated['quantity'],
            'unit_price' => $menuItem->price,
            'total_price' => $totalPrice,
        ]);

        if ($menuItem->stock > 0) {
            $menuItem->decrement('stock', $validated['quantity']);
        }

        return response()->json([
            'success' => true,
            'transaction_id' => $transaction->id,
            'total_amount' => $totalPrice,
            'message' => 'Penjualan berhasil!'
        ]);
    }

    /**
     * Get today's sales summary
     */
    public function todaySummary()
    {
        $todaySales = Auth::user()->transactions()
            ->where('type', 'income')
            ->whereDate('transaction_date', today())
            ->with('transactionDetails')
            ->get();

        $totalSales = $todaySales->sum('amount');
        $totalItems = $todaySales->sum(function ($transaction) {
            return $transaction->transactionDetails->sum('quantity');
        });

        return response()->json([
            'total_sales' => $totalSales,
            'total_items' => $totalItems,
            'transaction_count' => $todaySales->count()
        ]);
    }
}
