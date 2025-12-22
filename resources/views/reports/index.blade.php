@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-teh-jawa-cream via-white to-teh-jawa-gold-accent/20">
    <div class="container mx-auto px-4 py-6 md:py-8 max-w-5xl">
        
        <!-- Header Section -->
        <div class="mb-8 section-header flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-teh-jawa-gold to-teh-jawa-brown bg-clip-text text-transparent">
                    Laporan Keuangan
                </h1>
                <p class="text-xs md:text-sm text-teh-jawa-gray mt-1">Kelola semua laporan keuangan Anda</p>
            </div>
            <a href="{{ route('reports.create') }}" class="btn-teh-accent btn-teh-sm md:btn-teh-lg">
                <svg class="icon-sm md:icon-md" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <span>Buat Laporan</span>
            </a>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="alert-teh-success mb-6">
                {{ session('success') }}
            </div>
        @endif

        <!-- Reports Table -->
        <div class="card-teh-luxury border-teh-jawa-gold/20">
            @if($reports->count() > 0)
                <div class="overflow-x-auto">
                    <table class="table-teh">
                        <thead>
                            <tr>
                                <th>Periode</th>
                                <th class="text-right">Pemasukan</th>
                                <th class="text-right">Pengeluaran</th>
                                <th class="text-right">Laba / Rugi</th>
                                <th class="text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($reports as $report)
                        <tr>
                            <td>
                                <div>
                                    <a href="{{ route('reports.show', $report) }}" class="font-semibold text-teh-jawa-green hover:text-teh-jawa-green-dark">
                                        {{ \Carbon\Carbon::parse($report->period_start)->format('d M Y') }} - 
                                        {{ \Carbon\Carbon::parse($report->period_end)->format('d M Y') }}
                                    </a>
                                    <div class="text-xs text-teh-jawa-gray mt-1">
                                        Dibuat {{ \Carbon\Carbon::parse($report->report_date)->format('d M Y') }}
                                    </div>
                                </div>
                            </td>
                            <td class="text-right">
                                <span class="inline-block px-2 py-1 md:px-3 md:py-1 rounded-lg text-xs md:text-sm font-semibold bg-teh-jawa-green/10 text-teh-jawa-green">
                                    Rp {{ number_format($report->total_income, 0, ',', '.') }}
                                </span>
                            </td>
                            <td class="text-right">
                                <span class="inline-block px-2 py-1 md:px-3 md:py-1 rounded-lg text-xs md:text-sm font-semibold bg-red-100 text-red-700">
                                    Rp {{ number_format($report->total_expense, 0, ',', '.') }}
                                </span>
                            </td>
                            <td class="text-right">
                                <span class="inline-block px-2 py-1 md:px-3 md:py-1 rounded-lg text-xs md:text-sm font-semibold {{ $report->profit >= 0 ? 'bg-teh-jawa-gold/10 text-teh-jawa-gold' : 'bg-red-100 text-red-700' }}">
                                    Rp {{ number_format($report->profit, 0, ',', '.') }}
                                </span>
                            </td>
                            <td class="text-right">
                                <div class="flex gap-2 justify-end">
                                    <a href="{{ route('reports.show', $report) }}" class="btn-teh-ghost text-xs">
                                        <svg class="icon-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                    <form action="{{ route('reports.destroy', $report) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Yakin ingin menghapus laporan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-teh-ghost text-xs text-red-600 hover:text-red-700">
                                            <svg class="icon-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        @endforelse
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-12">
                    <div class="bg-teh-jawa-cream/30 w-16 h-16 rounded-full mx-auto flex items-center justify-center mb-3">
                        <svg class="icon-lg text-teh-jawa-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-teh-jawa-black mb-1">Belum ada laporan</h3>
                    <p class="text-xs md:text-sm text-teh-jawa-gray mb-4">Buat laporan keuangan pertama Anda untuk analisis mendalam</p>
                    <a href="{{ route('reports.create') }}" class="btn-teh-accent btn-teh-sm">
                        <svg class="icon-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <span>Buat Laporan Pertama</span>
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
