@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-teh-jawa-cream via-white to-teh-jawa-gold-accent/20">
    <div class="container mx-auto px-4 py-6 md:py-8 max-w-7xl">
        
        <!-- Header with Navigation Buttons -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                <div>
                    <h1 class="text-4xl md:text-5xl font-bold text-teh-jawa-black mb-2">📊 Dashboard</h1>
                    <p class="text-sm md:text-base text-teh-jawa-gray">Kelola keuangan & pesanan Teh Jawa Anda</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('transactions.create') }}" class="btn-teh-primary inline-flex items-center gap-2 py-2 px-4">
                        <svg class="icon-md" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <span>Transaksi</span>
                    </a>
                    <a href="{{ route('reports.create') }}" class="btn-teh-accent inline-flex items-center gap-2 py-2 px-4">
                        <svg class="icon-md" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span>Laporan</span>
                    </a>
                    <a href="{{ route('menu.index') }}" class="bg-orange-500 hover:bg-orange-600 text-white inline-flex items-center gap-2 py-2 px-4 rounded-lg font-semibold transition-all">
                        <svg class="icon-md" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                        </svg>
                        <span>Menu</span>
                    </a>
                    <a href="{{ route('orders.index') }}" class="bg-purple-500 hover:bg-purple-600 text-white inline-flex items-center gap-2 py-2 px-4 rounded-lg font-semibold transition-all">
                        <svg class="icon-md" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        <span>Pesanan</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Financial Summary Section -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-teh-jawa-black mb-4 flex items-center gap-2">
                <span class="w-1 h-8 bg-gradient-to-b from-teh-jawa-gold to-teh-jawa-brown rounded-full"></span>
                Ringkasan Keuangan Bulan Ini
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6">
                <!-- Income Card -->
                <div class="card-teh-luxury p-6 border-l-4 border-teh-jawa-green">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-sm font-semibold text-teh-jawa-green uppercase tracking-wide">Pemasukan</span>
                        <div class="bg-teh-jawa-green/10 p-3 rounded-lg">
                            <svg class="icon-lg text-teh-jawa-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-3xl md:text-4xl font-bold text-teh-jawa-black mb-2">Rp {{ number_format($monthlyIncome, 0) }}</p>
                    <p class="text-xs text-teh-jawa-gray">{{ $monthlyIncome > 0 ? round(($monthlyIncome / ($monthlyIncome + $monthlyExpense)) * 100, 0) : 0 }}% dari total pergerakan</p>
                </div>

                <!-- Expense Card -->
                <div class="card-teh-luxury p-6 border-l-4 border-red-500">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-sm font-semibold text-red-600 uppercase tracking-wide">Pengeluaran</span>
                        <div class="bg-red-100 p-3 rounded-lg">
                            <svg class="icon-lg text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-3xl md:text-4xl font-bold text-teh-jawa-black mb-2">Rp {{ number_format($monthlyExpense, 0) }}</p>
                    <p class="text-xs text-teh-jawa-gray">{{ $monthlyExpense > 0 ? round(($monthlyExpense / ($monthlyIncome + $monthlyExpense)) * 100, 0) : 0 }}% dari total pergerakan</p>
                </div>

                <!-- Profit Card -->
                <div class="card-teh-luxury p-6 border-l-4 {{ $monthlyProfit >= 0 ? 'border-teh-jawa-gold' : 'border-red-500' }}">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-sm font-semibold {{ $monthlyProfit >= 0 ? 'text-teh-jawa-gold' : 'text-red-600' }} uppercase tracking-wide">Laba Bersih</span>
                        <div class="{{ $monthlyProfit >= 0 ? 'bg-teh-jawa-gold/10' : 'bg-red-100' }} p-3 rounded-lg">
                            <svg class="icon-lg {{ $monthlyProfit >= 0 ? 'text-teh-jawa-gold' : 'text-red-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-3xl md:text-4xl font-bold {{ $monthlyProfit >= 0 ? 'text-teh-jawa-gold' : 'text-red-600' }} mb-2">Rp {{ number_format($monthlyProfit, 0) }}</p>
                    <p class="text-xs text-teh-jawa-gray">{{ $monthlyIncome > 0 ? round(($monthlyProfit/$monthlyIncome)*100, 0) : 0 }}% margin keuntungan</p>
                </div>
            </div>
        </div>

        <!-- Two Column Layout for Tables -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent Transactions -->
            <div>
                <h2 class="text-2xl font-bold text-teh-jawa-black mb-4 flex items-center gap-2">
                    <span class="w-1 h-8 bg-gradient-to-b from-teh-jawa-gold to-teh-jawa-brown rounded-full"></span>
                    Transaksi Terbaru
                </h2>
                
                <div class="card-teh-luxury border-teh-jawa-gold/20">
                    @if($recentTransactions->count() > 0)
                        <div class="overflow-x-auto mb-4">
                            <table class="table-teh text-sm">
                                <thead>
                                    <tr>
                                        <th class="text-left">Tanggal</th>
                                        <th class="text-left">Keterangan</th>
                                        <th class="text-right">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentTransactions as $transaction)
                                    <tr>
                                        <td class="whitespace-nowrap text-teh-jawa-black font-medium">
                                            {{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d M') }}
                                        </td>
                                        <td class="max-w-xs truncate text-teh-jawa-gray">{{ $transaction->description }}</td>
                                        <td class="text-right font-mono font-bold {{ $transaction->category === 'income' ? 'text-teh-jawa-green' : 'text-red-600' }}">
                                            {{ $transaction->category === 'income' ? '+' : '-' }} Rp {{ number_format($transaction->amount, 0) }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center pt-2 border-t border-teh-jawa-gold/10">
                            <a href="{{ route('transactions.index') }}" class="text-teh-jawa-gold font-semibold text-sm hover:text-teh-jawa-gold-dark">
                                Lihat Semua Transaksi →
                            </a>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="icon-lg text-teh-jawa-gold/30 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p class="text-teh-jawa-gray text-sm font-medium">Belum ada transaksi</p>
                            <a href="{{ route('transactions.create') }}" class="text-teh-jawa-gold font-semibold text-sm hover:text-teh-jawa-gold-dark mt-2">
                                Tambah Transaksi →
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Recent Reports -->
            <div>
                <h2 class="text-2xl font-bold text-teh-jawa-black mb-4 flex items-center gap-2">
                    <span class="w-1 h-8 bg-gradient-to-b from-teh-jawa-gold to-teh-jawa-brown rounded-full"></span>
                    Laporan Terbaru
                </h2>
                
                <div class="card-teh-luxury border-teh-jawa-gold/20">
                    @if($recentReports->count() > 0)
                        <div class="overflow-x-auto mb-4">
                            <table class="table-teh text-sm">
                                <thead>
                                    <tr>
                                        <th class="text-left">Periode</th>
                                        <th class="text-right">Hasil</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentReports as $report)
                                    <tr>
                                        <td>
                                            <a href="{{ route('reports.show', $report) }}" class="font-semibold text-teh-jawa-green hover:text-teh-jawa-green-dark text-sm">
                                                {{ \Carbon\Carbon::parse($report->period_start)->format('d M') }} - {{ \Carbon\Carbon::parse($report->period_end)->format('d M Y') }}
                                            </a>
                                        </td>
                                        <td class="text-right font-mono font-bold {{ $report->profit >= 0 ? 'text-teh-jawa-gold' : 'text-red-600' }}">
                                            Rp {{ number_format($report->profit, 0) }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center pt-2 border-t border-teh-jawa-gold/10">
                            <a href="{{ route('reports.index') }}" class="text-teh-jawa-gold font-semibold text-sm hover:text-teh-jawa-gold-dark">
                                Lihat Semua Laporan →
                            </a>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="icon-lg text-teh-jawa-gold/30 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p class="text-teh-jawa-gray text-sm font-medium">Belum ada laporan</p>
                            <a href="{{ route('reports.create') }}" class="text-teh-jawa-gold font-semibold text-sm hover:text-teh-jawa-gold-dark mt-2">
                                Buat Laporan →
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
