@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-teh-jawa-cream via-white to-teh-jawa-gold-accent/20">
    <div class="container mx-auto px-4 py-6 md:py-8 max-w-5xl">
        
        <!-- Header Section -->
        <div class="mb-8 section-header flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-teh-jawa-gold to-teh-jawa-brown bg-clip-text text-transparent">
                    Detail Laporan Keuangan
                </h1>
                <p class="text-xs md:text-sm text-teh-jawa-gray mt-1">
                    Periode: {{ \Carbon\Carbon::parse($report->period_start)->format('d M Y') }} - {{ \Carbon\Carbon::parse($report->period_end)->format('d M Y') }}
                </p>
            </div>
            <a href="{{ route('reports.index') }}" class="btn-teh-secondary btn-teh-sm md:btn-teh-lg flex items-center justify-center">
                <svg class="icon-sm md:icon-md" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Kembali</span>
            </a>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-5 mb-8">
            <!-- Income Card -->
            <div class="card-teh-luxury p-6 md:p-8 border-l-4 border-teh-jawa-green">
                <div class="flex items-center gap-3 mb-2">
                    <svg class="icon-lg text-teh-jawa-green bg-teh-jawa-green/10 p-2 rounded-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                </div>
                <p class="text-xs md:text-sm font-semibold text-teh-jawa-gray uppercase">Total Pemasukan</p>
                <p class="text-xl md:text-2xl font-bold text-teh-jawa-green mt-2">Rp {{ number_format($report->total_income, 0) }}</p>
            </div>

            <!-- Expense Card -->
            <div class="card-teh-luxury p-6 md:p-8 border-l-4 border-red-500">
                <div class="flex items-center gap-3 mb-2">
                    <svg class="icon-lg text-red-600 bg-red-100 p-2 rounded-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                    </svg>
                </div>
                <p class="text-xs md:text-sm font-semibold text-teh-jawa-gray uppercase">Total Pengeluaran</p>
                <p class="text-xl md:text-2xl font-bold text-red-600 mt-2">Rp {{ number_format($report->total_expense, 0) }}</p>
            </div>

            <!-- Profit/Loss Card -->
            <div class="card-teh-luxury p-6 md:p-8 border-l-4 {{ $report->profit >= 0 ? 'border-teh-jawa-gold' : 'border-red-500' }}">
                <div class="flex items-center gap-3 mb-2">
                    <svg class="icon-lg {{ $report->profit >= 0 ? 'text-teh-jawa-gold bg-teh-jawa-gold/10' : 'text-red-600 bg-red-100' }} p-2 rounded-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <p class="text-xs md:text-sm font-semibold text-teh-jawa-gray uppercase">Laba / Rugi</p>
                <p class="text-xl md:text-2xl font-bold {{ $report->profit >= 0 ? 'text-teh-jawa-gold' : 'text-red-600' }} mt-2">Rp {{ number_format($report->profit, 0) }}</p>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-3 mb-8">
            <a href="{{ route('reports.edit', $report) }}" class="btn-teh-primary btn-teh-sm md:btn-teh-lg flex items-center justify-center">
                <svg class="icon-sm md:icon-md" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                <span>Edit Laporan</span>
            </a>
            <form action="{{ route('reports.destroy', $report) }}" method="POST" class="inline-block w-full sm:w-auto">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-teh-danger btn-teh-sm md:btn-teh-lg w-full flex items-center justify-center" onclick="return confirm('Yakin ingin menghapus laporan ini?')">
                    <svg class="icon-sm md:icon-md" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    <span>Hapus Laporan</span>
                </button>
            </form>
        </div>

        <!-- Notes Section -->
        @if($report->notes)
        <div class="card-teh-luxury p-6 md:p-8 border-l-4 border-teh-jawa-brown mb-8">
            <h3 class="section-title flex items-center gap-3 mb-3">
                <svg class="icon-lg text-teh-jawa-brown bg-teh-jawa-brown/10 p-2 rounded-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <span>Catatan</span>
            </h3>
            <p class="text-xs md:text-sm text-teh-jawa-gray leading-relaxed">{{ $report->notes }}</p>
        </div>
        @endif

        <!-- Transactions Table -->
        <div class="card-teh-luxury border-teh-jawa-gold/20">
            <div class="p-4 md:p-6 border-b border-teh-jawa-gold/10">
                <h3 class="section-title flex items-center gap-3">
                    <svg class="icon-lg text-teh-jawa-gold bg-teh-jawa-gold/10 p-2 rounded-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Detail Transaksi</span>
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="table-teh">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Deskripsi</th>
                            <th>Kategori</th>
                            <th class="text-right">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($transactions as $transaction)
                    <tr>
                        <td class="text-xs md:text-sm text-teh-jawa-gray">
                            {{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d M Y') }}
                        </td>
                        <td class="text-xs md:text-sm">
                            <div class="font-semibold text-teh-jawa-black">{{ $transaction->description }}</div>
                            @if($transaction->payment_method)
                                <div class="text-xs text-teh-jawa-gray mt-0.5">{{ $transaction->payment_method }}</div>
                            @endif
                        </td>
                        <td class="text-xs md:text-sm">
                            <span class="inline-block px-2 md:px-3 py-1 rounded-lg text-xs font-semibold {{ $transaction->category == 'income' ? 'bg-teh-jawa-green/10 text-teh-jawa-green' : 'bg-red-100 text-red-700' }}">
                                {{ $transaction->category == 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                            </span>
                        </td>
                        <td class="text-right text-xs md:text-sm font-semibold {{ $transaction->category == 'income' ? 'text-teh-jawa-green' : 'text-red-600' }}">
                            {{ $transaction->category == 'income' ? '+' : '-' }}Rp {{ number_format($transaction->amount, 0) }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-8 md:py-12">
                            <div class="text-center">
                                <svg class="icon-lg mx-auto text-teh-jawa-gold/30 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                </svg>
                                <p class="text-xs md:text-sm text-teh-jawa-gray">Tidak ada transaksi dalam periode ini</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Report Created At -->
    <div class="mt-4 text-sm text-gray-500">
        Laporan dibuat pada {{ \Carbon\Carbon::parse($report->report_date)->format('d M Y \p\u\k\u\l H:i') }}
    </div>
</div>
@endsection