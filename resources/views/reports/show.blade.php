@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-teh-jawa-cream via-white to-teh-jawa-gold-accent/20">
    <div class="container mx-auto px-4 py-6 max-w-4xl">
        
        <!-- Header Section -->
        <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold bg-gradient-to-r from-teh-jawa-gold to-teh-jawa-brown bg-clip-text text-transparent">
                    Detail Laporan Keuangan
                </h1>
                <p class="text-xs md:text-sm text-teh-jawa-gray mt-1">
                    Periode: {{ \Carbon\Carbon::parse($report->period_start)->format('d M Y') }} - {{ \Carbon\Carbon::parse($report->period_end)->format('d M Y') }}
                </p>
            </div>
            <a href="{{ route('reports.index') }}" class="btn-teh-secondary btn-teh-sm flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Kembali</span>
            </a>
        </div>

        <!-- Summary Cards - 3 Column -->
        <div class="grid grid-cols-3 gap-3 mb-6">
            <!-- Income Card -->
            <div class="bg-white rounded-lg shadow-sm border-l-4 border-green-500 p-4">
                <p class="text-xs font-medium text-gray-500 uppercase">Pemasukan</p>
                <p class="text-lg md:text-xl font-bold text-green-600 mt-1">Rp {{ number_format($report->total_income, 0) }}</p>
            </div>

            <!-- Expense Card -->
            <div class="bg-white rounded-lg shadow-sm border-l-4 border-red-500 p-4">
                <p class="text-xs font-medium text-gray-500 uppercase">Pengeluaran</p>
                <p class="text-lg md:text-xl font-bold text-red-600 mt-1">Rp {{ number_format($report->total_expense, 0) }}</p>
            </div>

            <!-- Profit/Loss Card -->
            <div class="bg-white rounded-lg shadow-sm border-l-4 {{ $report->profit >= 0 ? 'border-teh-jawa-gold' : 'border-red-500' }} p-4">
                <p class="text-xs font-medium text-gray-500 uppercase">Laba/Rugi</p>
                <p class="text-lg md:text-xl font-bold {{ $report->profit >= 0 ? 'text-teh-jawa-gold' : 'text-red-600' }} mt-1">Rp {{ number_format($report->profit, 0) }}</p>
            </div>
        </div>

        <!-- Action Button -->
        <div class="mb-6">
            <a href="{{ route('reports.pdf', $report) }}" class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Cetak PDF
            </a>
        </div>

        <!-- Stats Grid - 4 Column -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">
            <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-blue-500">
                <p class="text-xs font-medium text-gray-500 uppercase">Total Transaksi</p>
                <p class="text-lg font-bold text-blue-600">{{ $transactionCount }}</p>
                <p class="text-xs text-gray-400">{{ $incomeCount }} masuk, {{ $expenseCount }} keluar</p>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-purple-500">
                <p class="text-xs font-medium text-gray-500 uppercase">Rata-rata</p>
                <p class="text-lg font-bold text-purple-600">Rp {{ number_format($avgTransactionValue, 0) }}</p>
                <p class="text-xs text-gray-400">Per transaksi</p>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-orange-500">
                <p class="text-xs font-medium text-gray-500 uppercase">Menu Terlaris</p>
                <p class="text-sm font-bold text-orange-600 truncate">
                    @if($incomeDetails->isNotEmpty())
                        {{ $incomeDetails->sortByDesc('quantity')->first()['menu_name'] }}
                    @else
                        -
                    @endif
                </p>
                <p class="text-xs text-gray-400">
                    @if($incomeDetails->isNotEmpty())
                        {{ $incomeDetails->sortByDesc('quantity')->first()['quantity'] }} terjual
                    @endif
                </p>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-pink-500">
                <p class="text-xs font-medium text-gray-500 uppercase">Pengeluaran Terbesar</p>
                <p class="text-sm font-bold text-pink-600 truncate">
                    @if($expenseDetails->isNotEmpty())
                        {{ $expenseDetails->sortByDesc('total_amount')->first()['category'] }}
                    @else
                        -
                    @endif
                </p>
                <p class="text-xs text-gray-400">
                    @if($expenseDetails->isNotEmpty())
                        Rp {{ number_format($expenseDetails->sortByDesc('total_amount')->first()['total_amount'], 0) }}
                    @endif
                </p>
            </div>
        </div>

        <!-- Detailed Breakdown - 2 Column -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <!-- Income Details -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="p-4 border-b bg-green-50">
                    <h3 class="text-sm font-semibold text-green-700 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Rincian Pemasukan per Menu
                    </h3>
                </div>
                <div class="p-4 max-h-64 overflow-y-auto">
                    @if($incomeDetails->isNotEmpty())
                        <div class="space-y-3">
                            @foreach($incomeDetails->sortByDesc('total_amount') as $detail)
                                <div class="flex justify-between items-center py-2 border-b border-gray-100 last:border-0">
                                    <div>
                                        <p class="text-sm font-medium text-gray-800">{{ $detail['menu_name'] }}</p>
                                        <p class="text-xs text-gray-500">{{ $detail['quantity'] }} item</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-semibold text-green-600">Rp {{ number_format($detail['total_amount'], 0) }}</p>
                                        <p class="text-xs text-gray-400">{{ round(($detail['total_amount'] / max($totalIncome, 1)) * 100, 1) }}%</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-6">
                            <p class="text-gray-400 text-sm">Tidak ada data pemasukan</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Expense Details -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="p-4 border-b bg-red-50">
                    <h3 class="text-sm font-semibold text-red-700 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                        </svg>
                        Rincian Pengeluaran per Kategori
                    </h3>
                </div>
                <div class="p-4 max-h-64 overflow-y-auto">
                    @if($expenseDetails->isNotEmpty())
                        <div class="space-y-3">
                            @foreach($expenseDetails->sortByDesc('total_amount') as $detail)
                                <div class="flex justify-between items-center py-2 border-b border-gray-100 last:border-0">
                                    <div>
                                        <p class="text-sm font-medium text-gray-800">{{ $detail['category'] }}</p>
                                        <p class="text-xs text-gray-500">{{ $detail['count'] }} transaksi</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-semibold text-red-600">Rp {{ number_format($detail['total_amount'], 0) }}</p>
                                        <p class="text-xs text-gray-400">{{ round(($detail['total_amount'] / max($totalExpense, 1)) * 100, 1) }}%</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-6">
                            <p class="text-gray-400 text-sm">Tidak ada data pengeluaran</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Transactions List -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6">
            <div class="p-4 border-b bg-gray-50">
                <h3 class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    Detail Transaksi
                </h3>
            </div>
            <div class="divide-y divide-gray-100 max-h-96 overflow-y-auto">
                @forelse($transactions as $transaction)
                    <div class="p-4 hover:bg-gray-50">
                        <div class="flex justify-between items-start">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-800 truncate">{{ $transaction->description }}</p>
                                <p class="text-xs text-gray-500 mt-0.5">
                                    {{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d M Y') }}
                                    @if($transaction->payment_method)
                                        · {{ $transaction->payment_method }}
                                    @endif
                                </p>
                                @if($transaction->transactionDetails->count() > 0)
                                    <div class="mt-2 space-y-0.5">
                                        @foreach($transaction->transactionDetails->take(3) as $detail)
                                            <p class="text-xs text-gray-400">{{ $detail->quantity }}x {{ $detail->menu_name }}</p>
                                        @endforeach
                                        @if($transaction->transactionDetails->count() > 3)
                                            <p class="text-xs text-gray-400">+{{ $transaction->transactionDetails->count() - 3 }} item lainnya</p>
                                        @endif
                                    </div>
                                @endif
                            </div>
                            <div class="text-right ml-4 flex-shrink-0">
                                <p class="text-sm font-semibold {{ $transaction->type == 'income' || $transaction->type == 'income_other' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $transaction->type == 'income' || $transaction->type == 'income_other' ? '+' : '-' }}Rp {{ number_format($transaction->amount, 0) }}
                                </p>
                                <span class="inline-block px-2 py-0.5 rounded text-xs font-medium {{ $transaction->type == 'income' || $transaction->type == 'income_other' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} mt-1">
                                    {{ $transaction->type == 'income' || $transaction->type == 'income_other' ? 'Masuk' : 'Keluar' }}
                                </span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <svg class="w-10 h-10 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                        <p class="text-gray-400 text-sm">Tidak ada transaksi dalam periode ini</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Report Footer -->
        <div class="text-center text-xs text-gray-400">
            Laporan dibuat pada {{ \Carbon\Carbon::parse($report->report_date)->format('d M Y \p\u\k\u\l H:i') }}
        </div>
    </div>
</div>
@endsection