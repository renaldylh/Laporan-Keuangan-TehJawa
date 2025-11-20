@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-teh-jawa-cream via-white to-teh-jawa-gold-accent/20">
    <div class="container mx-auto px-4 py-6 md:py-8 max-w-2xl">
        
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('reports.index') }}" class="text-teh-jawa-gold hover:text-teh-jawa-gold-dark font-semibold text-sm flex items-center gap-2 mb-4">
                <svg class="icon-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Laporan
            </a>
            <h1 class="text-4xl font-bold text-teh-jawa-black mb-2">Buat Laporan Keuangan</h1>
            <p class="text-teh-jawa-gray">Analisis keuangan bisnis Anda dalam periode tertentu</p>
        </div>

        <!-- Form Card with Clear Structure -->
        <div class="card-teh-luxury p-8 border-l-4 border-teh-jawa-gold">
            <form method="POST" action="{{ route('reports.store') }}" class="space-y-8">
                @csrf
                
                <!-- Step 1: Pilih Periode -->
                <div>
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-8 h-8 rounded-full bg-teh-jawa-gold text-white flex items-center justify-center font-bold text-sm">1</div>
                        <label class="text-lg font-bold text-teh-jawa-black">Pilih Periode Laporan</label>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="period_start" class="label-teh">Tanggal Mulai</label>
                            <div class="relative">
                                <input type="date" name="period_start" id="period_start" 
                                       class="input-teh w-full"
                                       value="{{ old('period_start', now()->startOfMonth()->format('Y-m-d')) }}" required>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="icon-sm text-teh-jawa-gray" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </div>
                            @error('period_start')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="period_end" class="label-teh">Tanggal Selesai</label>
                            <div class="relative">
                                <input type="date" name="period_end" id="period_end" 
                                       class="input-teh w-full"
                                       value="{{ old('period_end', now()->format('Y-m-d')) }}" required>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="icon-sm text-teh-jawa-gray" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </div>
                            @error('period_end')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="mt-4 p-4 bg-teh-jawa-gold/10 border border-teh-jawa-gold/30 rounded-lg">
                        <p class="text-sm text-teh-jawa-black">
                            <span class="font-semibold">💡 Tips:</span> Pilih periode bulanan untuk analisis yang lebih akurat
                        </p>
                    </div>
                </div>

                <div class="border-t border-teh-jawa-gold/10"></div>
                
                <!-- Step 2: Jenis Laporan -->
                <div>
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-8 h-8 rounded-full bg-teh-jawa-gold text-white flex items-center justify-center font-bold text-sm">2</div>
                        <label class="text-lg font-bold text-teh-jawa-black">Pilih Jenis Laporan</label>
                    </div>
                    <div class="space-y-3">
                        <label class="relative">
                            <input type="radio" name="report_type" value="summary" class="peer sr-only" {{ old('report_type', 'summary') == 'summary' ? 'checked' : '' }}>
                            <div class="p-5 rounded-lg border-2 border-gray-200 cursor-pointer transition-all duration-200 peer-checked:border-teh-jawa-gold peer-checked:bg-teh-jawa-gold/5 peer-checked:shadow-lg hover:border-teh-jawa-gold/50">
                                <div class="flex items-center gap-3">
                                    <div class="bg-teh-jawa-gold/20 p-3 rounded-lg flex-shrink-0">
                                        <svg class="icon-lg text-teh-jawa-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-bold text-teh-jawa-black text-base">Ringkasan Laporan</p>
                                        <p class="text-xs text-teh-jawa-gray">Ringkasan total pemasukan dan pengeluaran</p>
                                    </div>
                                </div>
                            </div>
                        </label>
                        
                        <label class="relative">
                            <input type="radio" name="report_type" value="detailed" class="peer sr-only" {{ old('report_type') == 'detailed' ? 'checked' : '' }}>
                            <div class="p-5 rounded-lg border-2 border-gray-200 cursor-pointer transition-all duration-200 peer-checked:border-teh-jawa-green peer-checked:bg-teh-jawa-green/5 peer-checked:shadow-lg hover:border-teh-jawa-green/50">
                                <div class="flex items-center gap-3">
                                    <div class="bg-teh-jawa-green/20 p-3 rounded-lg flex-shrink-0">
                                        <svg class="icon-lg text-teh-jawa-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-bold text-teh-jawa-green text-base">Transaksi Detail</p>
                                        <p class="text-xs text-teh-jawa-gray">Daftar semua transaksi dengan rincian lengkap</p>
                                    </div>
                                </div>
                            </div>
                        </label>
                        
                        <label class="relative">
                            <input type="radio" name="report_type" value="category" class="peer sr-only" {{ old('report_type') == 'category' ? 'checked' : '' }}>
                            <div class="p-5 rounded-lg border-2 border-gray-200 cursor-pointer transition-all duration-200 peer-checked:border-red-500 peer-checked:bg-red-50 peer-checked:shadow-lg hover:border-red-300">
                                <div class="flex items-center gap-3">
                                    <div class="bg-red-100 p-3 rounded-lg flex-shrink-0">
                                        <svg class="icon-lg text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v2.757a1 1 0 01-.808.983L13 9.935v5.028c0 .11-.09.2-.2.2h-1.6a.2.2 0 01-.2-.2v-5.028l-.192-.195A1 1 0 013 6.757V4z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-bold text-red-600 text-base">Rincian Kategori</p>
                                        <p class="text-xs text-teh-jawa-gray">Analisis berdasarkan kategori pemasukan/pengeluaran</p>
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>
                    @error('report_type')
                        <p class="text-red-500 text-sm mt-3 flex items-center gap-2">
                            <svg class="icon-sm" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="border-t border-teh-jawa-gold/10"></div>
                
                <!-- Step 3: Catatan Tambahan -->
                <div>
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-8 h-8 rounded-full bg-teh-jawa-gold text-white flex items-center justify-center font-bold text-sm">3</div>
                        <label class="text-lg font-bold text-teh-jawa-black">Tambahkan Catatan (Opsional)</label>
                    </div>
                    <textarea name="notes" id="notes" rows="3"
                              class="input-teh w-full resize-none"
                              placeholder="Catatan atau observasi khusus tentang laporan ini... (maks. 255 karakter)"
                              maxlength="255">{{ old('notes') }}</textarea>
                    <div class="flex justify-between mt-1.5">
                        <span class="text-xs text-teh-jawa-gray">Opsional - untuk referensi pribadi</span>
                        <span class="text-xs text-teh-jawa-gray">{{ strlen(old('notes')) }}/255</span>
                    </div>
                    @error('notes')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="border-t border-teh-jawa-gold/10 pt-6"></div>
                
                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 md:gap-4">
                    <a href="{{ route('reports.index') }}" class="btn-teh-secondary btn-teh-lg flex items-center justify-center">
                        <svg class="icon-md" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        <span>Batal</span>
                    </a>
                    <button type="submit" class="btn-teh-primary btn-teh-lg flex-1 flex items-center justify-center">
                        <svg class="icon-md" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span>Buat Laporan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection