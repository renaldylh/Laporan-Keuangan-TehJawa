<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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

        $transactions = Auth::user()->transactions()
            ->whereBetween('transaction_date', [
                $validated['period_start'],
                $validated['period_end']
            ])
            ->get();

        $totalIncome = $transactions->where('category', 'income')->sum('amount');
        $totalExpense = $transactions->where('category', 'expense')->sum('amount');
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
        
        $transactions = Transaction::where('user_id', $report->user_id)
            ->whereBetween('transaction_date', [
                $report->period_start,
                $report->period_end
            ])
            ->get();
            
        return view('reports.show', compact('report', 'transactions'));
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
}