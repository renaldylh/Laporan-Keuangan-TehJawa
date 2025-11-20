@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-teh-jawa-cream via-white to-teh-jawa-gold-accent/20">
    <div class="container mx-auto px-4 py-6 md:py-8 max-w-2xl">
        
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('menu.index') }}" class="text-teh-jawa-gold hover:text-teh-jawa-gold-dark font-semibold text-sm flex items-center gap-2 mb-4">
                <svg class="icon-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali ke Menu
            </a>
            <h1 class="text-4xl font-bold text-teh-jawa-black mb-2">Tambah Menu Baru</h1>
            <p class="text-teh-jawa-gray">Masukkan detail menu makanan baru</p>
        </div>

        <!-- Form Card -->
        <div class="card-teh-luxury p-8 border-l-4 border-teh-jawa-gold">
            <form method="POST" action="{{ route('menu.store') }}" class="space-y-6">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="label-teh">Nama Menu *</label>
                    <input type="text" name="name" id="name" 
                           class="input-teh w-full @error('name') border-red-500 @enderror" 
                           value="{{ old('name') }}" 
                           placeholder="Contoh: Paket Ayam Classic"
                           required>
                    @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category -->
                <div>
                    <label for="category" class="label-teh">Kategori *</label>
                    <select name="category" id="category" class="input-teh w-full @error('category') border-red-500 @enderror" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $key => $label)
                        <option value="{{ $key }}" {{ old('category') === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('category')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Price -->
                <div>
                    <label for="price" class="label-teh">Harga (Rp) *</label>
                    <input type="number" name="price" id="price" 
                           class="input-teh w-full @error('price') border-red-500 @enderror" 
                           value="{{ old('price') }}" 
                           step="0.01"
                           min="0"
                           placeholder="Contoh: 50000"
                           required>
                    @error('price')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="label-teh">Deskripsi</label>
                    <textarea name="description" id="description" 
                              class="input-teh w-full @error('description') border-red-500 @enderror" 
                              rows="3" 
                              placeholder="Jelaskan menu ini secara singkat...">{{ old('description') }}</textarea>
                    @error('description')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Notes -->
                <div>
                    <label for="notes" class="label-teh">Catatan (Topping/Variasi)</label>
                    <textarea name="notes" id="notes" 
                              class="input-teh w-full @error('notes') border-red-500 @enderror" 
                              rows="3" 
                              placeholder="Contoh: Topping: Bakso 37.273, Ayam 41.364...">{{ old('notes') }}</textarea>
                    @error('notes')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Stock -->
                <div>
                    <label for="stock" class="label-teh">Stok *</label>
                    <input type="number" name="stock" id="stock" 
                           class="input-teh w-full @error('stock') border-red-500 @enderror" 
                           value="{{ old('stock', -1) }}" 
                           min="-1"
                           placeholder="-1 untuk unlimited"
                           required>
                    <p class="text-xs text-teh-jawa-gray mt-1">Gunakan -1 untuk stok unlimited</p>
                    @error('stock')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Available Status -->
                <div class="flex items-center gap-3">
                    <input type="checkbox" name="is_available" id="is_available" 
                           class="w-4 h-4 rounded border-gray-300 cursor-pointer" 
                           value="1"
                           {{ old('is_available', true) ? 'checked' : '' }}>
                    <label for="is_available" class="label-teh cursor-pointer">Menu Tersedia</label>
                </div>

                <!-- Actions -->
                <div class="border-t border-teh-jawa-gold/10 pt-6 flex gap-4 justify-end">
                    <a href="{{ route('menu.index') }}" class="btn-teh-secondary">
                        Batal
                    </a>
                    <button type="submit" class="btn-teh-primary">
                        <svg class="icon-sm inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Simpan Menu
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection
