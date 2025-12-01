@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-teh-jawa-cream via-white to-teh-jawa-gold-accent/20">
    <div class="container mx-auto px-4 py-6 md:py-8">
        
        <!-- Header -->
        <div class="mb-8 flex justify-between items-start">
            <div>
                <h1 class="text-4xl font-bold text-teh-jawa-black mb-2">📋 Menu</h1>
                <p class="text-teh-jawa-gray">Pilih dan kelola menu makanan Teh Jawa</p>
            </div>
            @can('create-menu')
            <a href="{{ route('menu.create') }}" class="btn-teh-primary">
                <svg class="icon-sm inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Menu
            </a>
            @endcan
        </div>

        <!-- Category Filter -->
        <div class="mb-6 flex flex-wrap gap-2">
            <a href="{{ route('menu.index') }}" class="px-4 py-2 rounded-lg font-medium transition-all {{ !$category ? 'bg-teh-jawa-gold text-white' : 'bg-white text-teh-jawa-black border border-teh-jawa-gold hover:bg-teh-jawa-gold/10' }}">
                Semua Menu
            </a>
            @foreach($categories as $cat => $label)
            <a href="{{ route('menu.index', ['category' => $cat]) }}" class="px-4 py-2 rounded-lg font-medium transition-all {{ $category === $cat ? 'bg-teh-jawa-gold text-white' : 'bg-white text-teh-jawa-black border border-teh-jawa-gold hover:bg-teh-jawa-gold/10' }}">
                {{ $label }}
            </a>
            @endforeach
        </div>

        <!-- Menu Grid -->
        @if($menuItems->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            @foreach($menuItems as $item)
            <div class="card-teh-luxury hover:shadow-lg transition-all hover:-translate-y-1 relative">
                <!-- Status Badge -->
                <div class="absolute top-4 right-4 flex gap-2 pointer-events-none">
                    @if(!$item->is_available)
                    <span class="badge-teh bg-red-100 text-red-800">Tidak Tersedia</span>
                    @endif
                </div>

                <!-- Item Info -->
                <div class="mb-4">
                    <div class="inline-block px-3 py-1 bg-teh-jawa-gold/10 rounded-full text-xs font-semibold text-teh-jawa-gold mb-2">
                        {{ $item->category_label }}
                    </div>
                    <h3 class="text-lg font-bold text-teh-jawa-black mb-2">{{ $item->name }}</h3>
                    
                    @if($item->description)
                    <p class="text-sm text-teh-jawa-gray mb-2">{{ $item->description }}</p>
                    @endif

                    @if($item->notes)
                    <p class="text-xs text-teh-jawa-gray italic mb-3">{{ $item->notes }}</p>
                    @endif
                </div>

                <!-- Price -->
                <div class="border-t border-teh-jawa-gold/10 pt-4 mb-4">
                    <p class="text-2xl font-bold text-teh-jawa-gold">{{ $item->formatted_price }}</p>
                </div>

                <!-- Stock Info -->
                @if($item->stock !== -1)
                <div class="mb-4 text-sm">
                    <span class="text-teh-jawa-gray">Stok: </span>
                    <span class="font-semibold {{ $item->stock > 0 ? 'text-teh-jawa-green' : 'text-red-500' }}">
                        {{ $item->stock }}
                    </span>
                </div>
                @endif

                <!-- Actions -->
                <div class="flex gap-2">
                    <a href="{{ route('menu.show', $item) }}" class="flex-1 btn-teh-secondary text-center">
                        Lihat
                    </a>
                    @can('update-menu')
                    <a href="{{ route('menu.edit', $item) }}" class="flex-1 btn-teh-primary text-center">
                        Edit
                    </a>
                    @endcan
                    @can('delete-menu')
                    <form action="{{ route('menu.destroy', $item) }}" method="POST" class="flex-1" onsubmit="return confirm('Yakin hapus menu ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full btn-teh-danger">
                            Hapus
                        </button>
                    </form>
                    @endcan
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        {{ $menuItems->links() }}
        @else
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <p class="text-teh-jawa-gray text-lg">Tidak ada menu untuk kategori ini</p>
        </div>
        @endif

    </div>
</div>
@endsection
