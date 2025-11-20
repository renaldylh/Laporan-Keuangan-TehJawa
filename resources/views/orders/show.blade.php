@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-teh-jawa-cream via-white to-teh-jawa-gold-accent/20">
    <div class="container mx-auto px-4 py-6 md:py-8 max-w-3xl">
        <a href="{{ route('orders.index') }}" class="text-teh-jawa-gold hover:text-teh-jawa-gold-dark font-semibold text-sm flex items-center gap-2 mb-4">
            <svg class="icon-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Kembali ke Pesanan
        </a>

        <div class="card-teh-luxury p-8">
            <div class="flex justify-between items-start mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-teh-jawa-black">{{ $order->order_number }}</h1>
                    <p class="text-teh-jawa-gray">{{ $order->ordered_at->format('d F Y H:i') }}</p>
                </div>
                <span class="badge-teh bg-{{ $order->status_color }}-100 text-{{ $order->status_color }}-800 text-lg">
                    {{ $order->status_label }}
                </span>
            </div>

            <div class="border-t border-teh-jawa-gold/10 pt-6 mb-6">
                <h2 class="text-lg font-bold text-teh-jawa-black mb-4">Item Pesanan</h2>
                <div class="space-y-3">
                    @foreach($order->items as $item)
                    <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg">
                        <div>
                            <p class="font-semibold text-teh-jawa-black">{{ $item->menuItem->name }}</p>
                            <p class="text-sm text-teh-jawa-gray">{{ $item->quantity }}x @ {{ $item->menuItem->formatted_price }}</p>
                            @if($item->notes)
                            <p class="text-xs text-blue-600 mt-1">{{ $item->notes }}</p>
                            @endif
                        </div>
                        <p class="font-bold text-teh-jawa-gold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-teh-jawa-cream/50 rounded-lg p-6 mb-6">
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-teh-jawa-gray">Subtotal</span>
                        <span class="font-semibold">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-teh-jawa-gray">Pajak (10%)</span>
                        <span class="font-semibold">Rp {{ number_format($order->tax, 0, ',', '.') }}</span>
                    </div>
                    @if($order->discount > 0)
                    <div class="flex justify-between text-green-600">
                        <span>Diskon</span>
                        <span class="font-semibold">-Rp {{ number_format($order->discount, 0, ',', '.') }}</span>
                    </div>
                    @endif
                    <div class="border-t border-teh-jawa-gold/10 pt-3 flex justify-between">
                        <span class="font-bold">Total</span>
                        <span class="text-2xl font-bold text-teh-jawa-gold">{{ $order->formatted_total }}</span>
                    </div>
                </div>
            </div>

            @if($order->notes)
            <div class="bg-blue-50 rounded-lg p-4 mb-6">
                <p class="text-xs text-blue-600 mb-1 font-semibold">Catatan Pesanan</p>
                <p class="text-blue-900">{{ $order->notes }}</p>
            </div>
            @endif

            <div class="flex gap-3 justify-between">
                <a href="{{ route('orders.index') }}" class="flex-1 btn-teh-secondary text-center">
                    Kembali
                </a>
                @if($order->status === 'pending')
                <a href="{{ route('orders.edit', $order) }}" class="flex-1 btn-teh-primary text-center">
                    Edit Pesanan
                </a>
                <form action="{{ route('orders.destroy', $order) }}" method="POST" class="flex-1" onsubmit="return confirm('Batalkan pesanan ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full btn-teh-danger">Batalkan</button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
