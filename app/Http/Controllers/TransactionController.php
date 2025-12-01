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
            // Get all transactions (both income and expense) for the authenticated user
            $transactions = Auth::user()->transactions()
                ->with('transactionDetails') // Eager load transaction details
                ->orderBy('transaction_date', 'desc')
                ->paginate(10);
                
            // Calculate total income and expense for the summary
            $totalIncome = Auth::user()->transactions()
                ->where('type', 'income')
                ->sum('amount');
                
            $totalExpense = Auth::user()->transactions()
                ->where('type', 'expense')
                ->sum('amount');
                
            $balance = $totalIncome - $totalExpense;
                
            return view('transactions.index', compact('transactions', 'totalIncome', 'totalExpense', 'balance'));
            
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
            'Lain-lain'
        ];

        $incomeCategories = [
            'Catering',
            'Delivery Fee',
            'Service Charge',
            'Deposit Customer',
            'Sewa Tempat',
            'Lainnya'
        ];
        
        return view('transactions.create', compact('transactionTypes', 'expenseCategories', 'incomeCategories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'transaction_date' => 'required|date',
            'amount' => 'required|numeric|min:0',
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
            'amount' => 'required|numeric|min:0',
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