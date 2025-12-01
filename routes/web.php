<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SalesController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Sales System - Professional POS
    Route::get('/sales', [SalesController::class, 'index'])->name('sales.index');
    Route::post('/sales', [SalesController::class, 'store'])->name('sales.store');
    Route::post('/sales/quick', [SalesController::class, 'quickSale'])->name('sales.quick');
    Route::get('/sales/today-summary', [SalesController::class, 'todaySummary'])->name('sales.today-summary');

    // Transactions - For expenses only
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
    Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
    Route::get('/transactions/{transaction}', [TransactionController::class, 'show'])->name('transactions.show');
    Route::get('/transactions/{transaction}/edit', [TransactionController::class, 'edit'])->name('transactions.edit');
    Route::put('/transactions/{transaction}', [TransactionController::class, 'update'])->name('transactions.update');
    Route::delete('/transactions/{transaction}', [TransactionController::class, 'destroy'])->name('transactions.destroy');
    
    // Reports - Single integrated report
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/create', [ReportController::class, 'create'])->name('reports.create');
    Route::post('/reports/generate', [ReportController::class, 'generate'])->name('reports.generate');
    Route::get('/reports/{report}', [ReportController::class, 'show'])->name('reports.show');
    Route::get('/reports/{report}/pdf', [ReportController::class, 'download'])->name('reports.pdf');
    Route::get('/reports/{report}/edit', [ReportController::class, 'edit'])->name('reports.edit');
    Route::put('/reports/{report}', [ReportController::class, 'update'])->name('reports.update');
    Route::delete('/reports/{report}', [ReportController::class, 'destroy'])->name('reports.destroy');

    // Menu Management
    Route::resource('menu', MenuController::class);
    
    // Orders (Legacy - bisa dihapus jika tidak needed)
    Route::resource('orders', OrderController::class);
    
    // Debug POST Test Route
    Route::get('/debug-post', function () {
        return view('debug_post');
    });
    
    Route::post('/debug-post', function () {
        return response()->json([
            'success' => true,
            'message' => 'POST request successful!',
            'post_data' => request()->all(),
            'files' => request()->allFiles()
        ]);
    });
    
    // Additional Debug Routes
    Route::get('/debug-auth', function () {
        return response()->json([
            'authenticated' => \Illuminate\Support\Facades\Auth::check(),
            'user' => \Illuminate\Support\Facades\Auth::check() ? \Illuminate\Support\Facades\Auth::user()->email : null
        ]);
    });
    
    Route::get('/debug-menu', function () {
        $count = \App\Models\MenuItem::where('is_available', true)->count();
        return response()->json([
            'count' => $count,
            'authenticated' => \Illuminate\Support\Facades\Auth::check()
        ]);
    });
    
    Route::get('/debug-routes', function () {
        $routes = \Illuminate\Support\Facades\Route::getRoutes();
        $salesPostRoute = null;
        foreach ($routes as $route) {
            if ($route->uri() === 'sales' && in_array('POST', $route->methods())) {
                $salesPostRoute = $route;
                break;
            }
        }
        return response()->json([
            'sales_post' => !!$salesPostRoute,
            'routes_count' => count($routes)
        ]);
    });
    
    // Debug Route (hapus setelah selesai)
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
        $allTransactions = \App\Models\Transaction::orderBy('created_at', 'desc')->get();
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
});

require __DIR__.'/auth.php';