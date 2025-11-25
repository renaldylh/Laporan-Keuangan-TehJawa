@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-teh-jawa-cream via-white to-teh-jawa-gold-accent/20">
    <div class="container mx-auto px-4 py-6 md:py-8 max-w-2xl">
        
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('reports.show', $report) }}" class="text-teh-jawa-gold hover:text-teh-jawa-gold-dark font-semibold text-sm flex items-center gap-2 mb-4">
                <svg class="icon-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Laporan
            </a>
            <h1 class="text-4xl font-bold text-teh-jawa-black mb-2">Edit Catatan Laporan</h1>
            <p class="text-teh-jawa-gray">Perbarui catatan untuk laporan {{ $report->report_date->format('d F Y') }}</p>
        </div>

        <!-- Form Card -->
        <div class="card-teh-luxury p-8 border-l-4 border-teh-jawa-gold">
            <form method="POST" action="{{ route('reports.update', $report) }}" class="space-y-8">
                @csrf
                @method('PUT')
                
                <!-- Report Details Info -->
                <div class="bg-teh-jawa-cream/50 rounded-lg p-4 border border-teh-jawa-gold/20">
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <div>
                            <p class="text-sm text-teh-jawa-gray">Tanggal Laporan</p>
                            <p class="font-semibold text-teh-jawa-black">{{ $report->report_date->format('d F Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-teh-jawa-gray">Periode</p>
                            <p class="font-semibold text-teh-jawa-black">{{ $report->period_start->format('d M') }} - {{ $report->period_end->format('d M Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-teh-jawa-gray">Total Keuntungan</p>
                            <p class="font-semibold text-teh-jawa-green">Rp {{ number_format($report->profit, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Notes Section -->
                <div>
                    <label for="notes" class="label-teh">Catatan Laporan</label>
                    <textarea name="notes" id="notes" rows="8"
                              class="input-teh w-full"
                              placeholder="Tambahkan catatan atau analisis untuk laporan ini...">{{ old('notes', $report->notes) }}</textarea>
                    @error('notes')
                        <span class="text-teh-jawa-red text-sm mt-1 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-4 pt-4">
                    <button type="submit" class="btn-teh-primary flex-1 flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('reports.show', $report) }}" class="btn-teh-secondary flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Batal
                    </a>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection
