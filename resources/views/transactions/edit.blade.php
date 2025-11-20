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
            <h1 class="text-4xl font-bold text-teh-jawa-black mb-2">Edit Transaksi</h1>
            <p class="text-teh-jawa-gray">Perbarui data transaksi Anda</p>
        </div>

        <!-- Form Card with Clear Structure -->
        <div class="card-teh-luxury p-8 border-l-4 border-teh-jawa-gold">
            <form action="{{ route('transactions.update', $transaction) }}" method="POST" class="space-y-8">
                @csrf
                @method('PUT')
                
                <!-- Step 1: Jenis Transaksi -->
                <div>
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-8 h-8 rounded-full bg-teh-jawa-gold text-white flex items-center justify-center font-bold text-sm">1</div>
                        <label class="text-lg font-bold text-teh-jawa-black">Pilih Jenis Transaksi</label>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="relative">
                            <input type="radio" name="category" value="income" class="peer sr-only" {{ old('category', $transaction->category) == 'income' ? 'checked' : '' }}>
                            <div class="p-5 rounded-lg border-2 border-gray-200 cursor-pointer transition-all duration-200 peer-checked:border-teh-jawa-green peer-checked:bg-teh-jawa-green/5 peer-checked:shadow-lg hover:border-teh-jawa-green/50">
                                <div class="flex items-center gap-3">
                                    <div class="bg-teh-jawa-green/20 p-3 rounded-lg">
                                        <svg class="icon-lg text-teh-jawa-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-bold text-teh-jawa-green text-base">Pemasukan</p>
                                        <p class="text-xs text-teh-jawa-gray">Uang masuk ke akun</p>
                                    </div>
                                </div>
                            </div>
                        </label>
                        
                        <label class="relative">
                            <input type="radio" name="category" value="expense" class="peer sr-only" {{ old('category', $transaction->category) == 'expense' ? 'checked' : '' }}>
                            <div class="p-5 rounded-lg border-2 border-gray-200 cursor-pointer transition-all duration-200 peer-checked:border-red-500 peer-checked:bg-red-50 peer-checked:shadow-lg hover:border-red-300">
                                <div class="flex items-center gap-3">
                                    <div class="bg-red-100 p-3 rounded-lg">
                                        <svg class="icon-lg text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-bold text-red-600 text-base">Pengeluaran</p>
                                        <p class="text-xs text-teh-jawa-gray">Uang keluar dari akun</p>
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>
                    @error('category')
                        <p class="text-red-500 text-sm mt-3 flex items-center gap-2">
                            <svg class="icon-sm" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="border-t border-teh-jawa-gold/10"></div>
                
                <!-- Step 2: Detail Transaksi -->
                <div>
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-8 h-8 rounded-full bg-teh-jawa-gold text-white flex items-center justify-center font-bold text-sm">2</div>
                        <label class="text-lg font-bold text-teh-jawa-black">Isi Detail Transaksi</label>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="transaction_date" class="label-teh">Tanggal</label>
                            <div class="relative">
                                <input type="date" name="transaction_date" id="transaction_date" 
                                       class="input-teh w-full"
                                       value="{{ old('transaction_date', $transaction->transaction_date->format('Y-m-d')) }}"
                                       required>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="icon-sm text-teh-jawa-gray" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </div>
                            @error('transaction_date')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="amount" class="label-teh">Jumlah</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-teh-jawa-gray font-semibold">Rp</span>
                                <input type="number" step="0.01" name="amount" id="amount" 
                                       class="input-teh w-full pl-10"
                                       value="{{ old('amount', $transaction->amount) }}"
                                       placeholder="0"
                                       min="0"
                                       required>
                            </div>
                            @error('amount')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="border-t border-teh-jawa-gold/10"></div>
                
                <!-- Step 3: Deskripsi & Metode -->
                <div>
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-8 h-8 rounded-full bg-teh-jawa-gold text-white flex items-center justify-center font-bold text-sm">3</div>
                        <label class="text-lg font-bold text-teh-jawa-black">Informasi Tambahan</label>
                    </div>
                    
                    <div>
                        <label for="description" class="label-teh">Deskripsi / Keterangan</label>
                        <textarea name="description" id="description" rows="3" 
                                  class="input-teh w-full resize-none"
                                  placeholder="Jelaskan detail transaksi... (contoh: Gaji karyawan, Pembelian bahan baku, dll)"
                                  maxlength="255"
                                  required>{{ old('description', $transaction->description) }}</textarea>
                        <div class="flex justify-between mt-1.5">
                            <span class="text-xs text-teh-jawa-gray">Jelaskan tujuan transaksi</span>
                            <span class="text-xs text-teh-jawa-gray">{{ strlen(old('description', $transaction->description)) }}/255</span>
                        </div>
                        @error('description')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mt-6">
                        <label for="payment_method" class="label-teh">Metode Pembayaran</label>
                        <div class="relative">
                            <select name="payment_method" id="payment_method" 
                                    class="input-teh w-full appearance-none"
                                    required>
                                <option value="">Pilih metode pembayaran</option>
                                <option value="Tunai" {{ old('payment_method', $transaction->payment_method) == 'Tunai' ? 'selected' : '' }}>💵 Tunai</option>
                                <option value="Transfer Bank" {{ old('payment_method', $transaction->payment_method) == 'Transfer Bank' ? 'selected' : '' }}>🏦 Transfer Bank</option>
                                <option value="Kartu Debit" {{ old('payment_method', $transaction->payment_method) == 'Kartu Debit' ? 'selected' : '' }}>🏧 Kartu Debit</option>
                                <option value="E-Wallet" {{ old('payment_method', $transaction->payment_method) == 'E-Wallet' ? 'selected' : '' }}>📱 E-Wallet</option>
                                <option value="Lainnya" {{ old('payment_method', $transaction->payment_method) == 'Lainnya' ? 'selected' : '' }}>➕ Lainnya</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg class="icon-sm text-teh-jawa-gray" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                        @error('payment_method')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="border-t border-teh-jawa-gold/10 pt-6"></div>
                
                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 md:gap-4">
                    <a href="{{ route('transactions.index') }}" class="btn-teh-secondary btn-teh-lg flex items-center justify-center">
                        <svg class="icon-md" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        <span>Batal</span>
                    </a>
                    <button type="submit" class="btn-teh-primary btn-teh-lg flex-1 flex items-center justify-center">
                        <svg class="icon-md" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Simpan Perubahan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
