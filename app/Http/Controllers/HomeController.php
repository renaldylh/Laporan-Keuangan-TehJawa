<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        try {
            // Implement caching untuk dashboard data (10 min cache)
            $cacheKey = 'dashboard_' . auth()->id() . '_' . now()->format('Y-m-d_H');
            
            $dashboardData = cache()->remember($cacheKey, 60, function () {
                // Pastikan user ada dan authenticated
                if (!auth()->check()) {
                    return $this->getEmptyDashboardData();
                }
                
                $recentTransactions =auth()->user()->transactions()
                    ->select('id', 'transaction_date', 'description', 'type', 'amount')
                    ->with(['transactionDetails' => function($query) {
                        $query->select('transaction_id', 'menu_name', 'quantity')
                              ->take(3); // Limit at database level
                    }])
                    ->orderBy('transaction_date', 'desc')
                    ->take(5)
                    ->get();

                $currentMonthStart = now()->startOfMonth();
                $currentMonthEnd = now()->endOfMonth();

                // Optimasi query untuk monthly data
                $monthlyTransactions = auth()->user()->transactions()
                    ->whereBetween('transaction_date', [$currentMonthStart, $currentMonthEnd])
                    ->select('type', 'amount') // Hanya ambil kolom yang diperlukan
                    ->get();

                $monthlyIncome = $monthlyTransactions->where('type', 'income')->sum('amount');
                $monthlyExpense = $monthlyTransactions->where('type', 'expense')->sum('amount');
                $monthlyProfit = $monthlyIncome - $monthlyExpense;

                // Optimasi dengan raw DB query untuk chart data
                $chartData = DB::table('transactions')
                    ->selectRaw('DATE(transaction_date) as date, type, SUM(amount) as total')
                    ->where('user_id', auth()->id())
                    ->where('transaction_date', '>=', now()->subDays(30))
                    ->groupBy('date', 'type')
                    ->get()
                    ->groupBy('date');

                $chartLabels = [];
                $incomeData = [];
                $expenseData = [];

                for ($i = 29; $i >= 0; $i--) {
                    $date = now()->subDays($i)->format('Y-m-d');
                    $chartLabels[] = now()->subDays($i)->format('d M');
                    
                    $dayData = $chartData->get($date, collect());
                    $incomeData[] = $dayData->where('type', 'income')->sum('total');
                    $expenseData[] = $dayData->where('type', 'expense')->sum('total');
                }

                // Optimasi query untuk kategori pengeluaran
                $expenseCategories = DB::table('transactions')
                    ->selectRaw('description, SUM(amount) as total')
                    ->where('user_id', auth()->id())
                    ->where('type', 'expense')
                    ->where('transaction_date', '>=', now()->subDays(30))
                    ->groupBy('description')
                    ->get();

                $categoryLabels = [];
                $categoryData = [];

                foreach ($expenseCategories as $category) {
                    $categoryLabels[] = $category->description;
                    $categoryData[] = $category->total;
                }

                $recentReports = auth()->user()->reports()
                    ->select('id', 'period_start', 'period_end', 'profit', 'report_date')
                    ->orderBy('report_date', 'desc')
                    ->take(3)
                    ->get();

                return compact(
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
                );
            });
            
            return view('dashboard', $dashboardData);
        } catch (\Exception $e) {
            // Log error dan return data kosong
            \Log::error('Dashboard error: ' . $e->getMessage());
            return view('dashboard', $this->getEmptyDashboardData());
        }
    }
    
    /**
     * Get empty dashboard data structure
     */
    private function getEmptyDashboardData()
    {
        $chartLabels = [];
        $incomeData = [];
        $expenseData = [];
        
        for ($i = 29; $i >= 0; $i--) {
            $chartLabels[] = now()->subDays($i)->format('d M');
            $incomeData[] = 0;
            $expenseData[] = 0;
        }
        
        return [
            'recentTransactions' => collect(),
            'monthlyIncome' => 0,
            'monthlyExpense' => 0,
            'monthlyProfit' => 0,
            'recentReports' => collect(),
            'chartLabels' => $chartLabels,
            'incomeData' => $incomeData,
            'expenseData' => $expenseData,
            'categoryLabels' => [],
            'categoryData' => []
        ];
    }
}