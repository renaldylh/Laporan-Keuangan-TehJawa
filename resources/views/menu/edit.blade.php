@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-teh-jawa-cream via-white to-teh-jawa-gold-accent/20">
    <div class="container mx-auto px-4 py-6 md:py-8 max-w-2xl">
        
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('menu.show', $menuItem) }}" class="text-teh-jawa-gold hover:text-teh-jawa-gold-dark font-semibold text-sm flex items-center gap-2 mb-4">
                <svg class="icon-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali
            </a>
            <h1 class="text-4xl font-bold text-teh-jawa-black mb-2">Edit Menu</h1>
            <p class="text-teh-jawa-gray">Perbarui detail menu: {{ $menuItem->name }}</p>
        </div>

        <!-- Form Card -->
        <div class="card-teh-luxury p-8 border-l-4 border-teh-jawa-gold">
            <form method="POST" action="{{ route('menu.update', $menuItem) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Name -->
                <div>
                    <label for="name" class="label-teh">Nama Menu *</label>
                    <input type="text" name="name" id="name" 
                           class="input-teh w-full @error('name') border-red-500 @enderror" 
                           value="{{ old('name', $menuItem->name) }}" 
                           required>
                    @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category -->
                <div>
                    <label for="category" class="label-teh">Kategori *</label>
                    <select name="category" id="category" class="input-teh w-full @error('category') border-red-500 @enderror" required>
                        @foreach($categories as $key => $label)
                        <option value="{{ $key }}" {{ old('category', $menuItem->category) === $key ? 'selected' : '' }}>{{ $label }}</option>
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
                           value="{{ old('price', $menuItem->price) }}" 
                           step="0.01"
                           min="0"
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
                              rows="3">{{ old('description', $menuItem->description) }}</textarea>
                    @error('description')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Notes -->
                <div>
                    <label for="notes" class="label-teh">Catatan (Topping/Variasi)</label>
                    <textarea name="notes" id="notes" 
                              class="input-teh w-full @error('notes') border-red-500 @enderror" 
                              rows="3">{{ old('notes', $menuItem->notes) }}</textarea>
                    @error('notes')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Stock -->
                <div>
                    <label for="stock" class="label-teh">Stok *</label>
                    <input type="number" name="stock" id="stock" 
                           class="input-teh w-full @error('stock') border-red-500 @enderror" 
                           value="{{ old('stock', $menuItem->stock) }}" 
                           min="-1"
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
                           {{ old('is_available', $menuItem->is_available) ? 'checked' : '' }}>
                    <label for="is_available" class="label-teh cursor-pointer">Menu Tersedia</label>
                </div>

                <!-- Actions -->
                <div class="border-t border-teh-jawa-gold/10 pt-6 flex gap-4 justify-end">
                    <a href="{{ route('menu.show', $menuItem) }}" class="btn-teh-secondary">
                        Batal
                    </a>
                    <button type="submit" class="btn-teh-primary">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection
