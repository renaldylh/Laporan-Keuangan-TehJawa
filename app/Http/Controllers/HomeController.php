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
            ->with('transactionDetails.menuItem')
            ->orderBy('transaction_date', 'desc')
            ->take(5)
            ->get();

        $currentMonthStart = now()->startOfMonth();
        $currentMonthEnd = now()->endOfMonth();

        $monthlyTransactions = auth()->user()->transactions()
            ->whereBetween('transaction_date', [$currentMonthStart, $currentMonthEnd])
            ->get();

        $monthlyIncome = $monthlyTransactions->where('type', 'income')->sum('amount');
        $monthlyExpense = $monthlyTransactions->where('type', 'expense')->sum('amount');
        $monthlyProfit = $monthlyIncome - $monthlyExpense;

        // Data untuk diagram harian (30 hari terakhir)
        $dailyTransactions = auth()->user()->transactions()
            ->where('transaction_date', '>=', now()->subDays(30))
            ->orderBy('transaction_date')
            ->get()
            ->groupBy(function($transaction) {
                return $transaction->transaction_date->format('Y-m-d');
            });

        $chartLabels = [];
        $incomeData = [];
        $expenseData = [];

        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $chartLabels[] = now()->subDays($i)->format('d M');
            
            $dayTransactions = $dailyTransactions->get($date, collect());
            $incomeData[] = $dayTransactions->where('type', 'income')->sum('amount');
            $expenseData[] = $dayTransactions->where('type', 'expense')->sum('amount');
        }

        // Data untuk diagram kategori pengeluaran
        $expenseCategories = auth()->user()->transactions()
            ->where('type', 'expense')
            ->where('transaction_date', '>=', now()->subDays(30))
            ->get()
            ->groupBy('description');

        $categoryLabels = [];
        $categoryData = [];

        foreach ($expenseCategories as $description => $transactions) {
            $categoryLabels[] = $description;
            $categoryData[] = $transactions->sum('amount');
        }

        $recentReports = auth()->user()->reports()
            ->orderBy('report_date', 'desc')
            ->take(3)
            ->get();

        return view('dashboard', compact(
            'recentTransactions',
            'monthlyIncome',
            'monthlyExpense',
            'monthlyProfit',
            'recentReports',
            'chartLabels',
            'incomeData',
            'expenseData',
            'categoryLabels',
            'categoryData'
        ));
    }
}