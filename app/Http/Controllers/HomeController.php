<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Report;

class HomeController extends Controller
{
    /**
     * Display the dashboard with financial overview
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $recentTransactions = auth()->user()->transactions()
            ->orderBy('transaction_date', 'desc')
            ->take(5)
            ->get();

        $currentMonthStart = now()->startOfMonth();
        $currentMonthEnd = now()->endOfMonth();

        $monthlyTransactions = auth()->user()->transactions()
            ->whereBetween('transaction_date', [$currentMonthStart, $currentMonthEnd])
            ->get();

        $monthlyIncome = $monthlyTransactions->where('category', 'income')->sum('amount');
        $monthlyExpense = $monthlyTransactions->where('category', 'expense')->sum('amount');
        $monthlyProfit = $monthlyIncome - $monthlyExpense;

        $recentReports = auth()->user()->reports()
            ->orderBy('report_date', 'desc')
            ->take(3)
            ->get();

        return view('dashboard', compact(
            'recentTransactions',
            'monthlyIncome',
            'monthlyExpense',
            'monthlyProfit',
            'recentReports'
        ));
    }
}