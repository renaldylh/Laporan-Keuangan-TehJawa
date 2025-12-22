@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-teh-jawa-cream via-white to-teh-jawa-gold-accent/20">
    <div class="container mx-auto px-4 py-6 md:py-8 max-w-2xl">
        
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('transactions.index') }}" class="text-teh-jawa-gold hover:text-teh-jawa-gold-dark font-semibold text-sm flex items-center gap-2 mb-4">
                <svg class="icon-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Transaksi
            </a>
            <h1 class="text-4xl font-bold text-teh-jawa-black mb-2">Detail Transaksi</h1>
            <p class="text-teh-jawa-gray">Lihat informasi lengkap transaksi Anda</p>
        </div>

        <!-- Detail Card -->
        <div class="card-teh-luxury p-8 border-l-4 border-teh-jawa-gold">
            <div class="space-y-6">
                <!-- Transaction Type -->
                <div>
                    <label class="text-sm font-semibold text-teh-jawa-gray uppercase tracking-wide">Jenis Transaksi</label>
                    <div class="mt-2">
                        <span class="inline-block px-4 py-2 rounded-lg text-sm font-semibold {{ $transaction->category == 'income' ? 'bg-teh-jawa-green/10 text-teh-jawa-green' : 'bg-red-100 text-red-700' }}">
                            {{ $transaction->category == 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                        </span>
                    </div>
                </div>

                <div class="border-t border-teh-jawa-gold/10"></div>

                <!-- Amount -->
                <div>
                    <label class="text-sm font-semibold text-teh-jawa-gray uppercase tracking-wide">Jumlah</label>
                    <p class="text-3xl font-bold {{ $transaction->category == 'income' ? 'text-teh-jawa-green' : 'text-red-600' }} mt-2">
                        {{ $transaction->category == 'income' ? '+' : '-' }}Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                    </p>
                </div>

                <div class="border-t border-teh-jawa-gold/10"></div>

                <!-- Date -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-sm font-semibold text-teh-jawa-gray uppercase tracking-wide">Tanggal Transaksi</label>
                        <p class="text-teh-jawa-black font-semibold mt-2">{{ $transaction->transaction_date->format('d F Y') }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-teh-jawa-gray uppercase tracking-wide">Jam Pencatatan</label>
                        <p class="text-teh-jawa-black font-semibold mt-2">{{ $transaction->created_at->format('H:i') }}</p>
                    </div>
                </div>

                <div class="border-t border-teh-jawa-gold/10"></div>

                <!-- Description -->
                <div>
                    <label class="text-sm font-semibold text-teh-jawa-gray uppercase tracking-wide">Deskripsi</label>
                    <p class="text-teh-jawa-black mt-2 p-4 bg-teh-jawa-cream/30 rounded-lg">{{ $transaction->description }}</p>
                </div>

                <div class="border-t border-teh-jawa-gold/10"></div>

                <!-- Payment Method -->
                <div>
                    <label class="text-sm font-semibold text-teh-jawa-gray uppercase tracking-wide">Metode Pembayaran</label>
                    <p class="text-teh-jawa-black font-semibold mt-2">{{ $transaction->payment_method }}</p>
                </div>

                <div class="border-t border-teh-jawa-gold/10 pt-6"></div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 md:gap-4">
                    <a href="{{ route('transactions.index') }}" class="btn-teh-secondary btn-teh-lg flex items-center justify-center">
                        <svg class="icon-md" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        <span>Kembali</span>
                    </a>
                    <a href="{{ route('transactions.edit', $transaction) }}" class="btn-teh-primary btn-teh-lg flex-1 flex items-center justify-center">
                        <svg class="icon-md" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        <span>Edit Transaksi</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
