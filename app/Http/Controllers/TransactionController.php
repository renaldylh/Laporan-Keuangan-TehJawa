<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        try {
            // Implement caching untuk transaction data
            $cacheKey = 'transactions_' . auth()->id() . '_' . request('page', 1) . '_' . request('type', 'all');
            
            $result = cache()->remember($cacheKey, 180, function () {
                // Optimasi query dengan select specific columns dan eager loading
                $transactions = auth()->user()->transactions()
                    ->select('id', 'transaction_date', 'amount', 'description', 'type', 'payment_method', 'created_at')
                    ->with(['transactionDetails' => function($query) {
                        $query->select('id', 'transaction_id', 'menu_name', 'quantity', 'total_price');
                    }])
                    ->orderBy('transaction_date', 'desc')
                    ->paginate(10);
                
                // Optimasi query untuk summary dengan single query
                $summary = auth()->user()->transactions()
                    ->selectRaw('
                        SUM(CASE WHEN type = "income" THEN amount ELSE 0 END) as total_income,
                        SUM(CASE WHEN type = "expense" THEN amount ELSE 0 END) as total_expense
                    ')
                    ->first();
                
                $totalIncome = $summary->total_income ?? 0;
                $totalExpense = $summary->total_expense ?? 0;
                $balance = $totalIncome - $totalExpense;
                
                return compact('transactions', 'totalIncome', 'totalExpense', 'balance');
            });
            
            return view('transactions.index', $result);
            
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Error in TransactionController@index: ' . $e->getMessage());
            
            // Return a safe response with error message
            return back()->withErrors(['error' => 'Terjadi kesalahan saat memuat data transaksi. Silakan coba lagi.']);
        }
    }

    public function create()
    {
        $transactionTypes = [
            'expense' => 'Pengeluaran',
            'income_other' => 'Pemasukan Lain'
        ];
        
        $expenseCategories = [
            'Bayar Sampah',
            'PDAM',
            'Listrik',
            'Sewa Ruko',
            'Gaji Karyawan',
            'Bahan Baku',
            'Operasional',
            'Marketing',
            'Pajak',
            'Lainnya'
        ];

        $incomeCategories = [
            'Catering',
            'Delivery Fee',
            'Service Charge',
            'Deposit Customer',
            'Sewa Tempat',
            'Lain-lain'
        ];
        
        return view('transactions.create', compact('transactionTypes', 'expenseCategories', 'incomeCategories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'transaction_date' => 'required|date',
            'amount' => 'required|numeric', // Menghapus min:0 untuk mengizinkan nilai negatif
            'description' => 'required|string|max:255',
            'type' => 'required|in:expense,income_other',
            'payment_method' => 'required|string|max:50',
            'receipt' => 'nullable|file|mimes:jpeg,jpg,png,pdf|max:2048',
            'details' => 'nullable|array',
            'details.*.menu_name' => 'required|string|max:255',
            'details.*.quantity' => 'required|integer|min:1',
            'details.*.total_price' => 'required|numeric|min:0',
            'details.*.notes' => 'nullable|string|max:500',
        ]);

        // Convert income_other to income for database
        if ($validated['type'] === 'income_other') {
            $validated['type'] = 'income';
        }

        // Handle receipt upload
        $receiptPath = null;
        $receiptFilename = null;
        if (isset($validated['receipt']) && $validated['receipt']) {
            $receiptFile = $validated['receipt'];
            $receiptFilename = time() . '_' . $receiptFile->getClientOriginalName();
            $receiptPath = $receiptFile->storeAs('receipts', $receiptFilename, 'public');
        }

        $transaction = Auth::user()->transactions()->create([
            'transaction_date' => $validated['transaction_date'],
            'amount' => $validated['amount'],
            'description' => $validated['description'],
            'type' => $validated['type'],
            'payment_method' => $validated['payment_method'],
            'receipt_path' => $receiptPath,
            'receipt_filename' => $receiptFilename,
        ]);

        // Simpan transaction details jika ada
        if (isset($validated['details']) && is_array($validated['details'])) {
            foreach ($validated['details'] as $detail) {
                $transaction->transactionDetails()->create($detail);
            }
        }

        $message = $validated['type'] === 'income' ? 'Pemasukan berhasil dicatat.' : 'Pengeluaran berhasil dicatat.';
        
        return redirect()->route('transactions.index')
            ->with('success', $message);
    }

    public function show(Transaction $transaction)
    {
        $this->authorize('view', $transaction);
        $transaction->load('transactionDetails.menuItem');
        return view('transactions.show', compact('transaction'));
    }

    public function edit(Transaction $transaction)
    {
        $this->authorize('update', $transaction);
        return view('transactions.edit', compact('transaction'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $this->authorize('update', $transaction);

        $validated = $request->validate([
            'transaction_date' => 'required|date',
            'amount' => 'required|numeric', // Menghapus min:0 untuk mengizinkan nilai negatif
            'description' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
            'payment_method' => 'required|string|max:50',
        ]);

        $transaction->update($validated);

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction updated successfully.');
    }

    public function destroy(Transaction $transaction)
    {
        $this->authorize('delete', $transaction);
        $transaction->delete();

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction deleted successfully.');
    }
}