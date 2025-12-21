@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-teh-jawa-cream via-white to-teh-jawa-gold-accent/20">
    <div class="container mx-auto px-4 py-6 md:py-8 max-w-4xl">
        <a href="{{ route('orders.show', $order) }}" class="text-teh-jawa-gold hover:text-teh-jawa-gold-dark font-semibold text-sm flex items-center gap-2 mb-4">
            <svg class="icon-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Kembali
        </a>

        <h1 class="text-4xl font-bold text-teh-jawa-black mb-2">Edit Pesanan</h1>
        <p class="text-teh-jawa-gray mb-8">{{ $order->order_number }}</p>

        <form method="POST" action="{{ route('orders.update', $order) }}" class="space-y-6" id="orderForm">
            @csrf
            @method('PUT')

            <!-- Menu Selection -->
            <div class="card-teh-luxury p-8">
                <h2 class="text-xl font-bold text-teh-jawa-black mb-6">Ubah Menu</h2>
                
                <div id="orderItems" class="space-y-4 mb-6">
                    @foreach($order->items as $index => $item)
                    <div class="orderItem bg-gray-50 p-4 rounded-lg border-2 border-gray-200">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="label-teh">Menu Item</label>
                                <select name="items[{{ $index }}][menu_item_id]" class="input-teh w-full menuSelect" required>
                                    @foreach($menuItems as $category => $items)
                                    <optgroup label="{{ $categories[$category] }}">
                                        @foreach($items as $mitem)
                                        <option value="{{ $mitem->id }}" data-price="{{ $mitem->price }}" {{ $mitem->id === $item->menu_item_id ? 'selected' : '' }}>
                                            {{ $mitem->name }} - Rp {{ number_format($mitem->price, 0, ',', '.') }}
                                        </option>
                                        @endforeach
                                    </optgroup>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="label-teh">Jumlah</label>
                                <input type="number" name="items[{{ $index }}][quantity]" class="input-teh w-full" min="1" value="{{ $item->quantity }}" required>
                            </div>
                            <div class="md:col-span-2">
                                <label class="label-teh">Catatan</label>
                                <input type="text" name="items[{{ $index }}][notes]" class="input-teh w-full" value="{{ $item->notes ?? '' }}">
                            </div>
                            <button type="button" class="md:col-span-2 btn-teh-danger removeItem">Hapus Item</button>
                        </div>
                    </div>
                    @endforeach
                </div>

                <button type="button" id="addItem" class="btn-teh-secondary">
                    + Tambah Item Lain
                </button>
            </div>

            <!-- Order Notes -->
            <div class="card-teh-luxury p-8">
                <h2 class="text-xl font-bold text-teh-jawa-black mb-4">Catatan Pesanan</h2>
                <textarea name="notes" class="input-teh w-full" rows="3">{{ $order->notes }}</textarea>
            </div>

            <!-- Submit -->
            <div class="flex gap-4 justify-end">
                <a href="{{ route('orders.show', $order) }}" class="btn-teh-secondary">Batal</a>
                <button type="submit" class="btn-teh-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
let itemCount = {{ count($order->items) }};

document.getElementById('addItem').addEventListener('click', function() {
    const template = document.querySelector('.orderItem').cloneNode(true);
    template.innerHTML = template.innerHTML.replace(/\[\d+\]/g, '[' + itemCount + ']');
    template.querySelector('.removeItem').style.display = 'block';
    document.getElementById('orderItems').appendChild(template);
    itemCount++;
    attachRemoveListeners();
});

function attachRemoveListeners() {
    document.querySelectorAll('.removeItem').forEach(btn => {
        btn.addEventListener('click', function() {
            if(document.querySelectorAll('.orderItem').length > 1) {
                this.closest('.orderItem').remove();
            }
        });
    });
}

attachRemoveListeners();
</script>
@endsection
