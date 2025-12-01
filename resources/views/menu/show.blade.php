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
        </div>

        <!-- Detail Card -->
        <div class="card-teh-luxury p-8 border-l-4 border-teh-jawa-gold">
            
            <!-- Status Badge -->
            <div class="flex gap-2 mb-6">
                @if(!$menuItem->is_available)
                <span class="badge-teh bg-red-100 text-red-800">Tidak Tersedia</span>
                @else
                <span class="badge-teh bg-green-100 text-green-800">Tersedia</span>
                @endif
                <span class="badge-teh bg-teh-jawa-gold/10 text-teh-jawa-gold">{{ $menuItem->category_label }}</span>
            </div>

            <!-- Name -->
            <h1 class="text-4xl font-bold text-teh-jawa-black mb-2">{{ $menuItem->name }}</h1>

            <!-- Description -->
            @if($menuItem->description)
            <p class="text-teh-jawa-gray mb-6">{{ $menuItem->description }}</p>
            @endif

            <!-- Price Section -->
            <div class="bg-teh-jawa-gold/5 rounded-lg p-6 mb-6 border-l-4 border-teh-jawa-gold">
                <p class="text-sm text-teh-jawa-gray mb-1">Harga</p>
                <p class="text-4xl font-bold text-teh-jawa-gold">{{ $menuItem->formatted_price }}</p>
            </div>

            <!-- Details Grid -->
            <div class="grid grid-cols-2 gap-4 mb-6">
                <!-- Category -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-xs text-teh-jawa-gray mb-1">Kategori</p>
                    <p class="font-semibold text-teh-jawa-black">{{ $menuItem->category_label }}</p>
                </div>

                <!-- Stock -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-xs text-teh-jawa-gray mb-1">Stok</p>
                    <p class="font-semibold {{ $menuItem->stock > 0 || $menuItem->stock === -1 ? 'text-teh-jawa-green' : 'text-red-500' }}">
                        @if($menuItem->stock === -1)
                            Unlimited
                        @else
                            {{ $menuItem->stock }} unit
                        @endif
                    </p>
                </div>
            </div>

            <!-- Notes -->
            @if($menuItem->notes)
            <div class="bg-blue-50 rounded-lg p-4 mb-6 border-l-4 border-blue-400">
                <p class="text-xs text-blue-600 mb-2 font-semibold">Catatan / Variasi</p>
                <p class="text-sm text-blue-900">{{ $menuItem->notes }}</p>
            </div>
            @endif

            <!-- Meta Information -->
            <div class="border-t border-teh-jawa-gold/10 pt-6 mb-6">
                @if($menuItem->created_at)
                <p class="text-xs text-teh-jawa-gray">
                    Ditambahkan: <span class="font-semibold">{{ $menuItem->created_at->format('d F Y H:i') }}</span>
                </p>
                @endif
                @if($menuItem->updated_at)
                <p class="text-xs text-teh-jawa-gray">
                    Terakhir diupdate: <span class="font-semibold">{{ $menuItem->updated_at->format('d F Y H:i') }}</span>
                </p>
                @endif
            </div>

            <!-- Actions -->
            <div class="flex gap-3 justify-between">
                <a href="{{ route('menu.index') }}" class="flex-1 btn-teh-secondary text-center">
                    Kembali
                </a>
                @can('update-menu')
                <a href="{{ route('menu.edit', $menuItem) }}" class="flex-1 btn-teh-primary text-center">
                    <svg class="icon-sm inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit
                </a>
                @endcan
                @can('delete-menu')
                <form action="{{ route('menu.destroy', $menuItem) }}" method="POST" class="flex-1" onsubmit="return confirm('Yakin menghapus menu ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full btn-teh-danger">
                        <svg class="icon-sm inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Hapus
                    </button>
                </form>
                @endcan
            </div>
        </div>

    </div>
</div>
@endsection
