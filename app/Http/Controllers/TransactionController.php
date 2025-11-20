<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Auth::user()->transactions()
            ->orderBy('transaction_date', 'desc')
            ->paginate(10);
            
        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        return view('transactions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'transaction_date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'description' => 'required|string|max:255',
            'category' => 'required|in:income,expense',
            'payment_method' => 'required|string|max:50',
        ]);

        Auth::user()->transactions()->create($validated);

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction added successfully.');
    }

    public function show(Transaction $transaction)
    {
        $this->authorize('view', $transaction);
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
            'category' => 'required|in:income,expense',
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