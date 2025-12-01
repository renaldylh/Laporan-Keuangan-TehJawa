@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-teh-jawa-cream via-white to-teh-jawa-gold-accent/20">
    <div class="container mx-auto px-4 py-6 md:py-8 max-w-7xl">
        
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                <div>
                    <h1 class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-teh-jawa-gold to-teh-jawa-brown bg-clip-text text-transparent mb-2">Dashboard</h1>
                    <p class="text-sm md:text-base text-teh-jawa-gray">Kelola keuangan & pesanan Teh Jawa Anda</p>
                </div>
            </div>
        </div>

        <!-- Financial Summary Section -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold bg-gradient-to-r from-teh-jawa-gold to-teh-jawa-brown bg-clip-text text-transparent mb-4 flex items-center gap-2">
                <span class="w-1 h-8 bg-gradient-to-b from-teh-jawa-gold to-teh-jawa-brown rounded-full"></span>
                Ringkasan Keuangan Bulan Ini
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6">
                <!-- Income Card -->
                <a href="{{ route('transactions.index', ['type' => 'income']) }}" class="block group">
                    <div class="card-teh-luxury p-6 border-l-4 border-teh-jawa-green hover:shadow-lg transition-all duration-300 hover:scale-[1.02] cursor-pointer">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-sm font-semibold text-teh-jawa-green uppercase tracking-wide">Pemasukan</span>
                            <div class="bg-teh-jawa-green/10 p-3 rounded-lg group-hover:bg-teh-jawa-green/20 transition-colors">
                                <svg class="icon-lg text-teh-jawa-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-3xl md:text-4xl font-bold text-teh-jawa-black mb-2">Rp {{ number_format($monthlyIncome, 0) }}</p>
                        <p class="text-xs text-teh-jawa-gray">{{ $monthlyIncome > 0 ? round(($monthlyIncome / ($monthlyIncome + $monthlyExpense)) * 100, 0) : 0 }}% dari total pergerakan</p>
                    </div>
                </a>

                <!-- Expense Card -->
                <a href="{{ route('transactions.index', ['type' => 'expense']) }}" class="block group">
                    <div class="card-teh-luxury p-6 border-l-4 border-red-500 hover:shadow-lg transition-all duration-300 hover:scale-[1.02] cursor-pointer">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-sm font-semibold text-red-600 uppercase tracking-wide">Pengeluaran</span>
                            <div class="bg-red-100 p-3 rounded-lg group-hover:bg-red-200 transition-colors">
                                <svg class="icon-lg text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-3xl md:text-4xl font-bold text-teh-jawa-black mb-2">Rp {{ number_format($monthlyExpense, 0) }}</p>
                        <p class="text-xs text-teh-jawa-gray">{{ $monthlyExpense > 0 ? round(($monthlyExpense / ($monthlyIncome + $monthlyExpense)) * 100, 0) : 0 }}% dari total pergerakan</p>
                    </div>
                </a>

                <!-- Profit Card -->
                <a href="{{ route('reports.index') }}" class="block group">
                    <div class="card-teh-luxury p-6 border-l-4 {{ $monthlyProfit >= 0 ? 'border-teh-jawa-gold' : 'border-red-500' }} hover:shadow-lg transition-all duration-300 hover:scale-[1.02] cursor-pointer">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-sm font-semibold {{ $monthlyProfit >= 0 ? 'text-teh-jawa-gold' : 'text-red-600' }} uppercase tracking-wide">Laba Bersih</span>
                            <div class="{{ $monthlyProfit >= 0 ? 'bg-teh-jawa-gold/10' : 'bg-red-100' }} p-3 rounded-lg group-hover:{{ $monthlyProfit >= 0 ? 'bg-teh-jawa-gold/20' : 'bg-red-200' }} transition-colors">
                                <svg class="icon-lg {{ $monthlyProfit >= 0 ? 'text-teh-jawa-gold' : 'text-red-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-3xl md:text-4xl font-bold {{ $monthlyProfit >= 0 ? 'text-teh-jawa-gold' : 'text-red-600' }} mb-2">Rp {{ number_format($monthlyProfit, 0) }}</p>
                        <p class="text-xs text-teh-jawa-gray">{{ $monthlyIncome > 0 ? round(($monthlyProfit/$monthlyIncome)*100, 0) : 0 }}% margin keuntungan</p>
                    </div>
                </a>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold bg-gradient-to-r from-teh-jawa-gold to-teh-jawa-brown bg-clip-text text-transparent mb-4 flex items-center gap-2">
                <span class="w-1 h-8 bg-gradient-to-b from-teh-jawa-gold to-teh-jawa-brown rounded-full"></span>
                Diagram Keuangan 30 Hari Terakhir
            </h2>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Line Chart - Income vs Expense -->
                <div class="card-teh-luxury p-6">
                    <h3 class="text-lg font-semibold bg-gradient-to-r from-teh-jawa-gold to-teh-jawa-brown bg-clip-text text-transparent mb-4">Pemasukan vs Pengeluaran</h3>
                    <div class="relative h-80">
                        <canvas id="incomeExpenseChart"></canvas>
                    </div>
                </div>

                <!-- Pie Chart - Expense Categories -->
                <div class="card-teh-luxury p-6">
                    <h3 class="text-lg font-semibold bg-gradient-to-r from-teh-jawa-gold to-teh-jawa-brown bg-clip-text text-transparent mb-4">Rincian Pengeluaran</h3>
                    <div class="relative h-80">
                        <canvas id="expenseCategoryChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Two Column Layout for Tables -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent Transactions -->
            <div>
                <h2 class="text-2xl font-bold bg-gradient-to-r from-teh-jawa-gold to-teh-jawa-brown bg-clip-text text-transparent mb-4 flex items-center gap-2">
                    <span class="w-1 h-8 bg-gradient-to-b from-teh-jawa-gold to-teh-jawa-brown rounded-full"></span>
                    Transaksi Terbaru
                </h2>
                
                <div class="card-teh-luxury border-teh-jawa-gold/20">
                    @if($recentTransactions->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="border-b border-teh-jawa-gold/10">
                                        <th class="text-left py-3 px-4 font-semibold text-teh-jawa-gray uppercase text-xs">Tanggal</th>
                                        <th class="text-left py-3 px-4 font-semibold text-teh-jawa-gray uppercase text-xs">Keterangan</th>
                                        <th class="text-right py-3 px-4 font-semibold text-teh-jawa-gray uppercase text-xs">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentTransactions as $transaction)
                                    <tr class="border-b border-gray-50 hover:bg-gray-50 transition-colors">
                                        <td class="py-3 px-4">
                                            <span class="text-teh-jawa-black font-medium">{{ $transaction->transaction_date->format('d M') }}</span>
                                        </td>
                                        <td class="py-3 px-4">
                                            <div class="text-teh-jawa-black font-medium">{{ $transaction->description }}</div>
                                            @if($transaction->transactionDetails->count() > 0)
                                                <div class="mt-1 flex flex-wrap gap-1">
                                                    @foreach($transaction->transactionDetails->take(3) as $detail)
                                                        <span class="inline-block bg-teh-jawa-cream/50 text-teh-jawa-gray rounded px-2 py-0.5 text-xs">
                                                            {{ $detail->quantity }}x {{ $detail->menu_name }}
                                                        </span>
                                                    @endforeach
                                                    @if($transaction->transactionDetails->count() > 3)
                                                        <span class="text-xs text-teh-jawa-gray">+{{ $transaction->transactionDetails->count() - 3 }} lainnya</span>
                                                    @endif
                                                </div>
                                            @endif
                                        </td>
                                        <td class="py-3 px-4 text-right">
                                            <span class="font-mono font-bold {{ $transaction->type === 'income' ? 'text-teh-jawa-green' : 'text-red-600' }}">
                                                {{ $transaction->type === 'income' ? '+' : '-' }} Rp {{ number_format($transaction->amount, 0) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center pt-4 border-t border-teh-jawa-gold/10">
                            <a href="{{ route('transactions.index') }}" class="inline-flex items-center text-teh-jawa-gold font-semibold text-sm hover:text-teh-jawa-brown transition-colors">
                                Lihat Semua Transaksi
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="w-16 h-16 bg-teh-jawa-cream/30 rounded-full mx-auto flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-teh-jawa-gold/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <p class="text-teh-jawa-gray font-medium mb-3">Belum ada transaksi</p>
                            <a href="{{ route('transactions.create') }}" class="inline-flex items-center text-teh-jawa-gold font-semibold text-sm hover:text-teh-jawa-brown transition-colors">
                                Tambah Transaksi
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Recent Reports -->
            <div>
                <h2 class="text-2xl font-bold bg-gradient-to-r from-teh-jawa-gold to-teh-jawa-brown bg-clip-text text-transparent mb-4 flex items-center gap-2">
                    <span class="w-1 h-8 bg-gradient-to-b from-teh-jawa-gold to-teh-jawa-brown rounded-full"></span>
                    Laporan Terbaru
                </h2>
                
                <div class="card-teh-luxury border-teh-jawa-gold/20">
                    @if($recentReports->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="border-b border-teh-jawa-gold/10">
                                        <th class="text-left py-3 px-4 font-semibold text-teh-jawa-gray uppercase text-xs">Periode</th>
                                        <th class="text-right py-3 px-4 font-semibold text-teh-jawa-gray uppercase text-xs">Hasil</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentReports as $report)
                                    <tr class="border-b border-gray-50 hover:bg-gray-50 transition-colors">
                                        <td class="py-3 px-4">
                                            <a href="{{ route('reports.show', $report) }}" class="font-semibold text-teh-jawa-black hover:text-teh-jawa-gold transition-colors">
                                                {{ $report->period_start->format('d M') }} - {{ $report->period_end->format('d M Y') }}
                                            </a>
                                        </td>
                                        <td class="py-3 px-4 text-right">
                                            <span class="font-mono font-bold {{ $report->profit >= 0 ? 'text-teh-jawa-gold' : 'text-red-600' }}">
                                                Rp {{ number_format($report->profit, 0) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center pt-4 border-t border-teh-jawa-gold/10">
                            <a href="{{ route('reports.index') }}" class="inline-flex items-center text-teh-jawa-gold font-semibold text-sm hover:text-teh-jawa-brown transition-colors">
                                Lihat Semua Laporan
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="w-16 h-16 bg-teh-jawa-cream/30 rounded-full mx-auto flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-teh-jawa-gold/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <p class="text-teh-jawa-gray font-medium mb-3">Belum ada laporan</p>
                            <a href="{{ route('reports.create') }}" class="inline-flex items-center text-teh-jawa-gold font-semibold text-sm hover:text-teh-jawa-brown transition-colors">
                                Buat Laporan
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Data dari controller
        const chartLabels = @json($chartLabels);
        const incomeData = @json($incomeData);
        const expenseData = @json($expenseData);
        const categoryLabels = @json($categoryLabels);
        const categoryData = @json($categoryData);

        // Chart 1: Line Chart - Income vs Expense
        const incomeExpenseCanvas = document.getElementById('incomeExpenseChart');
        if (incomeExpenseCanvas) {
            const ctx1 = incomeExpenseCanvas.getContext('2d');
            const hasLineData = incomeData.some(val => val > 0) || expenseData.some(val => val > 0);

            if (!hasLineData) {
                incomeExpenseCanvas.parentElement.innerHTML = `
                    <div class="flex h-full items-center justify-center text-center">
                        <div>
                            <svg class="w-12 h-12 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p class="mt-3 text-sm text-gray-500">Belum ada data transaksi dalam 30 hari terakhir.</p>
                        </div>
                    </div>
                `;
            } else {
                new Chart(ctx1, {
                    type: 'line',
                    data: {
                        labels: chartLabels,
                        datasets: [{
                            label: 'Pemasukan',
                            data: incomeData,
                            borderColor: 'rgb(34, 197, 94)',
                            backgroundColor: 'rgba(34, 197, 94, 0.15)',
                            pointBackgroundColor: 'rgb(34, 197, 94)',
                            pointRadius: 3,
                            tension: 0.35,
                            fill: true
                        }, {
                            label: 'Pengeluaran',
                            data: expenseData,
                            borderColor: 'rgb(239, 68, 68)',
                            backgroundColor: 'rgba(239, 68, 68, 0.15)',
                            pointBackgroundColor: 'rgb(239, 68, 68)',
                            pointRadius: 3,
                            tension: 0.35,
                            fill: true
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    usePointStyle: true,
                                    padding: 16
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        let label = context.dataset.label || '';
                                        if (label) {
                                            label += ': ';
                                        }
                                        label += 'Rp ' + new Intl.NumberFormat('id-ID').format(context.parsed.y || 0);
                                        return label;
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                                    }
                                },
                                grid: {
                                    color: 'rgba(148, 163, 184, 0.15)'
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                });
            }
        } else {
            console.warn('Canvas #incomeExpenseChart tidak ditemukan.');
        }

        const expenseCategoryCanvas = document.getElementById('expenseCategoryChart');
        if (expenseCategoryCanvas) {
            const ctx2 = expenseCategoryCanvas.getContext('2d');
            const hasPieData = Array.isArray(categoryData) && categoryData.some(val => val > 0);

            if (!hasPieData) {
                expenseCategoryCanvas.parentElement.innerHTML = `
                    <div class="flex h-full items-center justify-center text-center">
                        <div>
                            <svg class="w-12 h-12 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="mt-3 text-sm text-gray-500">Belum ada data pengeluaran kategori.</p>
                        </div>
                    </div>
                `;
            } else {
                new Chart(ctx2, {
                    type: 'doughnut',
                    data: {
                        labels: categoryLabels,
                        datasets: [{
                            data: categoryData,
                            backgroundColor: [
                                'rgba(239, 68, 68, 0.85)',
                                'rgba(245, 158, 11, 0.85)',
                                'rgba(59, 130, 246, 0.85)',
                                'rgba(16, 185, 129, 0.85)',
                                'rgba(139, 92, 246, 0.85)',
                                'rgba(236, 72, 153, 0.85)',
                                'rgba(251, 146, 60, 0.85)',
                                'rgba(250, 204, 21, 0.85)'
                            ],
                            borderWidth: 2,
                            borderColor: '#fff'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '65%',
                        plugins: {
                            legend: {
                                position: 'right',
                                labels: {
                                    boxWidth: 14,
                                    boxHeight: 14,
                                    padding: 12
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        let label = context.label || '';
                                        if (label) {
                                            label += ': ';
                                        }
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0) || 1;
                                        const percentage = ((context.parsed / total) * 100).toFixed(1);
                                        label += 'Rp ' + new Intl.NumberFormat('id-ID').format(context.parsed || 0) + ' (' + percentage + '%)';
                                        return label;
                                    }
                                }
                            }
                        }
                    }
                });
            }
        } else {
            console.warn('Canvas #expenseCategoryChart tidak ditemukan.');
        }
    });
</script>
@endpush
@endsection
