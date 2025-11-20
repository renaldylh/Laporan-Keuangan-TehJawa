@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-teh-jawa-cream via-white to-teh-jawa-gold-accent/20">
    <div class="container mx-auto px-4 py-6 md:py-8">
        
        <!-- Header -->
        <div class="mb-8 flex justify-between items-start">
            <div>
                <h1 class="text-4xl font-bold text-teh-jawa-black mb-2">🛒 Pesanan Saya</h1>
                <p class="text-teh-jawa-gray">Kelola semua pesanan Anda</p>
            </div>
            <a href="{{ route('orders.create') }}" class="btn-teh-primary">
                <svg class="icon-sm inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Pesanan Baru
            </a>
        </div>

        <!-- Orders Table -->
        @if($orders->count() > 0)
        <div class="space-y-4 mb-8">
            @foreach($orders as $order)
            <div class="card-teh-luxury p-6 hover:shadow-lg transition-all">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-lg font-bold text-teh-jawa-black">{{ $order->order_number }}</h3>
                        <p class="text-sm text-teh-jawa-gray">{{ $order->ordered_at->format('d F Y H:i') }}</p>
                    </div>
                    <span class="badge-teh bg-{{ $order->status_color }}-100 text-{{ $order->status_color }}-800">
                        {{ $order->status_label }}
                    </span>
                </div>

                <!-- Items Count & Total -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <p class="text-xs text-teh-jawa-gray">Item</p>
                        <p class="text-xl font-bold text-teh-jawa-black">{{ $order->items()->count() }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-teh-jawa-gray">Total</p>
                        <p class="text-xl font-bold text-teh-jawa-gold">{{ $order->formatted_total }}</p>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex gap-3 pt-4 border-t border-teh-jawa-gold/10">
                    <a href="{{ route('orders.show', $order) }}" class="flex-1 btn-teh-secondary text-center">
                        Lihat Detail
                    </a>
                    @if($order->status === 'pending')
                    <a href="{{ route('orders.edit', $order) }}" class="flex-1 btn-teh-primary text-center">
                        Edit
                    </a>
                    <form action="{{ route('orders.destroy', $order) }}" method="POST" class="flex-1" onsubmit="return confirm('Yakin batalkan pesanan ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full btn-teh-danger">
                            Batalkan
                        </button>
                    </form>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        {{ $orders->links() }}
        @else
        <div class="text-center py-12 card-teh-luxury">
            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
            </svg>
            <p class="text-teh-jawa-gray text-lg mb-6">Belum ada pesanan</p>
            <a href="{{ route('orders.create') }}" class="btn-teh-primary inline-block">
                Buat Pesanan Pertama
            </a>
        </div>
        @endif

    </div>
</div>
@endsection
