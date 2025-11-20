@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-teh-jawa-cream via-white to-teh-jawa-gold-accent/20">
    <div class="container mx-auto px-4 py-6 md:py-8 max-w-5xl">
        
        <!-- Header Section -->
        <div class="mb-8 section-header flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-teh-jawa-gold to-teh-jawa-brown bg-clip-text text-transparent">
                    Daftar Transaksi
                </h1>
                <p class="text-xs md:text-sm text-teh-jawa-gray mt-1">Kelola semua transaksi keuangan Anda</p>
            </div>
            <a href="{{ route('transactions.create') }}" class="btn-teh-primary btn-teh-sm md:btn-teh-lg">
                <svg class="icon-sm md:icon-md" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>Transaksi Baru</span>
            </a>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="alert-teh-success mb-6">
                {{ session('success') }}
            </div>
        @endif

        <!-- Transactions Table -->
        <div class="card-teh-luxury border-teh-jawa-gold/20">
            @if($transactions->count() > 0)
                <div class="overflow-x-auto">
                    <table class="table-teh">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Deskripsi</th>
                                <th>Kategori</th>
                                <th class="text-right">Jumlah</th>
                                <th class="text-right">Aksi</th>
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
                            <td class="text-right">
                                <div class="flex gap-2 justify-end">
                                    <a href="{{ route('transactions.edit', $transaction) }}" class="btn-teh-ghost text-xs">
                                        <svg class="icon-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    <form action="{{ route('transactions.destroy', $transaction) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')">
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-teh-jawa-black mb-1">Belum ada transaksi</h3>
                    <p class="text-xs md:text-sm text-teh-jawa-gray mb-4">Catat transaksi pertama Anda untuk melacak keuangan</p>
                    <a href="{{ route('transactions.create') }}" class="btn-teh-primary btn-teh-sm">
                        <svg class="icon-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <span>Tambah Transaksi Pertama</span>
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
