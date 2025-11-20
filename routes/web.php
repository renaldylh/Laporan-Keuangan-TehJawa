<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('transactions', TransactionController::class);
    
    Route::prefix('reports')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('reports.index');
        Route::get('create', [ReportController::class, 'create'])->name('reports.create');
        Route::post('/', [ReportController::class, 'store'])->name('reports.store');
        Route::get('{report}', [ReportController::class, 'show'])->name('reports.show');
        Route::delete('{report}', [ReportController::class, 'destroy'])->name('reports.destroy');
    });

    Route::resource('menu', MenuController::class);
    Route::resource('orders', OrderController::class);
});

require __DIR__.'/auth.php';