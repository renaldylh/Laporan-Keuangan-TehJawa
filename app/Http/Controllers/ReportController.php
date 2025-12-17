<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $reports = Auth::user()->reports()
            ->select('id', 'report_date', 'period_start', 'period_end', 'total_income', 'total_expense', 'profit')
            ->orderBy('report_date', 'desc')
            ->paginate(10);
            
        return view('reports.index', compact('reports'));
    }

    public function create()
    {
        return view('reports.create');
    }

    public function store(Request $request)
    {
        return $this->generate($request);
    }

    public function generate(Request $request)
    {
        $validated = $request->validate([
            'period_start' => 'required|date',
            'period_end' => 'required|date|after_or_equal:period_start',
            'notes' => 'nullable|string',
        ]);

        // Optimized query dengan selectRaw untuk aggregation
        $summary = Auth::user()->transactions()
            ->selectRaw('
                SUM(CASE WHEN type = "income" THEN amount ELSE 0 END) as total_income,
                SUM(CASE WHEN type = "expense" THEN amount ELSE 0 END) as total_expense
            ')
            ->whereBetween('transaction_date', [
                $validated['period_start'],
                $validated['period_end']
            ])
            ->first();

        $totalIncome = $summary->total_income ?? 0;
        $totalExpense = $summary->total_expense ?? 0;
        $profit = $totalIncome - $totalExpense;

        $report = Auth::user()->reports()->create([
            'report_date' => now(),
            'period_start' => $validated['period_start'],
            'period_end' => $validated['period_end'],
            'total_income' => $totalIncome,
            'total_expense' => $totalExpense,
            'profit' => $profit,
            'notes' => $validated['notes'],
        ]);

        return redirect()->route('reports.show', $report)
            ->with('success', 'Report generated successfully.');
    }

    public function show(Report $report)
    {
        if ($report->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        // Optimized query dengan select minimal columns
        $transactions = Transaction::where('user_id', $report->user_id)
            ->select('id', 'transaction_date', 'amount', 'description', 'type', 'payment_method')
            ->with(['transactionDetails' => function($query) {
                $query->select('transaction_id', 'menu_name', 'quantity', 'total_price');
            }])
            ->whereBetween('transaction_date', [
                $report->period_start,
                $report->period_end
            ])
            ->get();

        $viewData = $this->buildReportData($report, $transactions);

        return view('reports.show', $viewData);
    }

    public function edit(Report $report)
    {
        if ($report->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('reports.edit', compact('report'));
    }

    public function update(Request $request, Report $report)
    {
        if ($report->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'notes' => 'nullable|string',
        ]);

        $report->update($validated);

        return redirect()->route('reports.show', $report)
            ->with('success', 'Report updated successfully.');
    }

    public function destroy(Report $report)
    {
        if ($report->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $report->delete();
        
        return redirect()->route('reports.index')
            ->with('success', 'Report deleted successfully.');
    }

    public function download(Report $report)
    {
        if ($report->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Optimized query dengan select minimal columns
        $transactions = Transaction::where('user_id', $report->user_id)
            ->select('id', 'transaction_date', 'amount', 'description', 'type', 'payment_method')
            ->with(['transactionDetails' => function($query) {
                $query->select('transaction_id', 'menu_name', 'quantity', 'total_price');
            }])
            ->whereBetween('transaction_date', [
                $report->period_start,
                $report->period_end
            ])
            ->get();

        $viewData = $this->buildReportData($report, $transactions);

        $pdf = Pdf::loadView('reports.pdf', $viewData)->setPaper('a4', 'portrait');

        $fileName = 'laporan-tehjawa-' . $report->period_start->format('Ymd') . '-' . $report->period_end->format('Ymd') . '.pdf';

        return $pdf->download($fileName);
    }

    private function buildReportData(Report $report, $transactions)
    {
        $totalIncome = $transactions->where('type', 'income')->sum('amount');
        $totalExpense = $transactions->where('type', 'expense')->sum('amount');
        $profit = $totalIncome - $totalExpense;

        $incomeDetails = collect();
        $incomeTransactions = $transactions->where('type', 'income');
        foreach ($incomeTransactions as $transaction) {
            foreach ($transaction->transactionDetails as $detail) {
                $key = $detail->menu_name;
                if (!$incomeDetails->has($key)) {
                    $incomeDetails->put($key, [
                        'menu_name' => $detail->menu_name,
                        'quantity' => 0,
                        'total_amount' => 0,
                    ]);
                }
                // Convert to array first to avoid indirect modification error
                $currentDetail = $incomeDetails->get($key);
                $currentDetail['quantity'] += $detail->quantity;
                $currentDetail['total_amount'] += $detail->total_price;
                $incomeDetails->put($key, $currentDetail);
            }
        }

        $incomeDetails = $incomeDetails->map(function ($detail) {
            $detail['avg_price'] = $detail['quantity'] > 0 ? $detail['total_amount'] / $detail['quantity'] : 0;
            return $detail;
        });

        $expenseDetails = collect();
        $expenseTransactions = $transactions->where('type', 'expense');
        foreach ($expenseTransactions as $transaction) {
            foreach ($transaction->transactionDetails as $detail) {
                $key = $detail->menu_name;
                if (!$expenseDetails->has($key)) {
                    $expenseDetails->put($key, [
                        'category' => $detail->menu_name,
                        'total_amount' => 0,
                        'count' => 0,
                    ]);
                }
                // Convert to array first to avoid indirect modification error
                $currentExpense = $expenseDetails->get($key);
                $currentExpense['total_amount'] += $detail->total_price;
                $currentExpense['count']++;
                $expenseDetails->put($key, $currentExpense);
            }
        }

        $transactionCount = $transactions->count();
        $incomeCount = $incomeTransactions->count();
        $expenseCount = $expenseTransactions->count();
        $avgTransactionValue = $incomeCount > 0 ? $totalIncome / $incomeCount : 0;

        return [
            'report' => $report,
            'transactions' => $transactions,
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'profit' => $profit,
            'incomeDetails' => $incomeDetails,
            'expenseDetails' => $expenseDetails,
            'transactionCount' => $transactionCount,
            'incomeCount' => $incomeCount,
            'expenseCount' => $expenseCount,
            'avgTransactionValue' => $avgTransactionValue,
        ];
    }
}