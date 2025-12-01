<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

// Route untuk debugging (hapus setelah selesai)
Route::get('/debug-transactions', function () {
    echo "<h1>DEBUG TRANSAKSI</h1>";
    
    // 1. Cek user yang login
    echo "<h2>User Authentication</h2>";
    echo "Authenticated: " . (Auth::check() ? 'YES' : 'NO') . "<br>";
    if (Auth::check()) {
        echo "User ID: " . Auth::id() . "<br>";
        echo "User Name: " . Auth::user()->name . "<br>";
        echo "User Email: " . Auth::user()->email . "<br>";
    }
    
    // 2. Cek semua transaksi
    echo "<h2>All Transactions in Database</h2>";
    $allTransactions = Transaction::orderBy('created_at', 'desc')->get();
    echo "Total: " . $allTransactions->count() . "<br><br>";
    
    foreach ($allTransactions as $tx) {
        echo "ID: {$tx->id}, User ID: {$tx->user_id}, Type: {$tx->type}, Amount: Rp " . number_format($tx->amount, 0, ',', '.') . "<br>";
        echo "Description: {$tx->description}<br>";
        echo "Transaction Date: {$tx->transaction_date}<br>";
        echo "Created At: {$tx->created_at}<br><br>";
    }
    
    // 3. Cek transaksi user yang login (jika ada)
    if (Auth::check()) {
        echo "<h2>Current User's Transactions</h2>";
        $userTransactions = Auth::user()->transactions()->orderBy('transaction_date', 'desc')->get();
        echo "Total: " . $userTransactions->count() . "<br><br>";
        
        foreach ($userTransactions as $tx) {
            echo "ID: {$tx->id}, Type: {$tx->type}, Amount: Rp " . number_format($tx->amount, 0, ',', '.') . "<br>";
            echo "Description: {$tx->description}<br>";
            echo "Transaction Date: {$tx->transaction_date}<br><br>";
        }
    }
    
    // 4. Test query TransactionController
    echo "<h2>TransactionController Query Test</h2>";
    if (Auth::check()) {
        try {
            $transactions = Auth::user()->transactions()
                ->with('transactionDetails')
                ->orderBy('transaction_date', 'desc')
                ->paginate(10);
            
            echo "Query Result: " . $transactions->count() . " transactions<br>";
            
            if ($transactions->count() > 0) {
                echo "<table border='1'>";
                echo "<tr><th>ID</th><th>Date</th><th>Type</th><th>Amount</th><th>Description</th></tr>";
                foreach ($transactions as $tx) {
                    echo "<tr>";
                    echo "<td>{$tx->id}</td>";
                    echo "<td>{$tx->transaction_date}</td>";
                    echo "<td>{$tx->type}</td>";
                    echo "<td>Rp " . number_format($tx->amount, 0, ',', '.') . "</td>";
                    echo "<td>{$tx->description}</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "No transactions found for this user!";
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Please login first!";
    }
    
    echo "<br><br><a href='/login'>Go to Login</a> | <a href='/transactions'>Go to Transactions</a>";
});
