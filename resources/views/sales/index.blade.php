@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Top Navigation Bar -->
    <div class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-40">
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <h1 class="text-2xl font-bold text-gray-900">TehJawa POS</h1>
                    <span class="ml-3 px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Online</span>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="text-sm text-gray-600">
                        {{ now()->format('l, d F Y') }}
                    </div>
                    <div class="text-sm font-medium text-gray-900">
                        {{ now()->format('H:i') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Layout -->
    <div class="flex flex-col lg:flex-row h-[calc(100vh-4rem)]">
        
        <!-- Left: Products Section -->
        <div class="flex-1 flex flex-col bg-white border-r border-gray-200">
            
            <!-- Category Navigation -->
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-900">Menu Produk</h2>
                    <div class="flex items-center space-x-2">
                        <button class="p-2 text-gray-400 hover:text-gray-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                
                <!-- Category Tabs -->
                <div class="flex space-x-1 mt-4 overflow-x-auto">
                    <button class="category-tab active px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg whitespace-nowrap" data-category="all">
                        Semua
                    </button>
                    @foreach($categories as $category)
                        <button class="category-tab px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors whitespace-nowrap" data-category="{{ $category }}">
                            {{ ucfirst($category) }}
                        </button>
                    @endforeach
                </div>
            </div>
            
            <!-- Products Grid -->
            <div class="flex-1 overflow-y-auto p-6">
                <!-- Debug Info -->
                <div class="mb-4 p-2 bg-gray-100 rounded text-xs">
                    Debug: Menu Items Count: {{ $menuItems->count() }}, Categories: {{ $categories->count() }}
                </div>
                
                <div id="menuGrid" class="grid grid-cols-4 gap-4 p-4" style="display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 1rem; padding: 1rem;">
                    @if($menuItems->count() > 0)
                        @foreach($menuItems as $menuItem)
                        <div class="menu-item-card group cursor-pointer" 
                             data-menu-id="{{ $menuItem->id }}" 
                             data-menu-name="{{ $menuItem->name }}" 
                             data-menu-price="{{ $menuItem->price }}"
                             data-category="{{ $menuItem->category }}">
                            
                            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden hover:border-blue-300 hover:shadow-md transition-all duration-200">
                                <!-- Product Image -->
                                <div class="aspect-square bg-gradient-to-br from-blue-50 to-indigo-100 flex items-center justify-center relative">
                                    @php
                                        $imageUrl = $menuItem->image_url ?: asset('images/menu-placeholder.svg');
                                    @endphp
                                    <img src="{{ $imageUrl }}"
                                         alt="{{ $menuItem->name }}"
                                         class="w-full h-full object-cover"
                                         onerror="this.onerror=null;this.src='{{ asset('images/menu-placeholder.svg') }}';">
                                    @if($menuItem->stock > 0 && $menuItem->stock <= 5)
                                        <span class="absolute top-2 right-2 px-2 py-1 text-xs font-medium bg-orange-500 text-white rounded-full">
                                            {{ $menuItem->stock }}
                                        </span>
                                    @endif
                                </div>
                                
                                <!-- Product Info -->
                                <div class="p-3">
                                    <h4 class="font-medium text-sm text-gray-900 line-clamp-2 leading-tight mb-1">
                                        {{ $menuItem->name }}
                                    </h4>
                                    @if($menuItem->category)
                                        <p class="text-xs text-gray-500 mb-2">{{ ucfirst($menuItem->category) }}</p>
                                    @endif
                                    <div class="text-sm font-bold text-gray-900 mb-2">Rp {{ number_format($menuItem->price, 0) }}</div>
                                    
                                    <!-- Simple Quantity Controls -->
                                    <div class="flex items-center gap-1">
                                        <button class="quantity-decrease w-7 h-7 text-gray-600 hover:bg-gray-100 rounded transition-colors flex items-center justify-center">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                            </svg>
                                        </button>
                                        <input type="number" 
                                               class="quantity-input w-8 text-center text-sm font-medium bg-transparent border-0 focus:ring-0" 
                                               value="1" 
                                               min="1" 
                                               max="99">
                                        <button class="quantity-increase w-7 h-7 text-gray-600 hover:bg-gray-100 rounded transition-colors flex items-center justify-center">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                            </svg>
                                        </button>
                                        <button class="add-to-cart-btn flex-1 px-2 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors text-xs font-medium">
                                            Add
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @else
                        <div class="col-span-full text-center py-12">
                            <div class="bg-gray-100 w-16 h-16 rounded-full mx-auto flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Menu</h3>
                            <p class="text-gray-500 mb-4">Tambahkan menu item terlebih dahulu untuk memulai penjualan</p>
                            <a href="{{ route('menu.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Tambah Menu
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Right: Cart & Checkout -->
        <div class="w-full lg:w-96 bg-white border-l border-gray-200 flex flex-col">
            <!-- Right Sidebar - Cart -->
            <div class="lg:col-span-1 bg-white rounded-lg shadow-sm border border-gray-200 flex flex-col h-[calc(100vh-2rem)]">
                <div class="bg-gradient-to-r from-teh-jawa-gold to-teh-jawa-brown text-white px-4 py-3 flex items-center justify-between sticky top-0 z-10">
                    <h2 class="font-semibold text-lg">Transaksi Hari Ini</h2>
                    <span id="cartCount" class="bg-white text-teh-jawa-gold text-xs font-bold w-6 h-6 rounded-full flex items-center justify-center">0</span>
                </div>
                
                <!-- Cart Items -->
                <div id="cartItems" class="flex-1 overflow-y-auto p-4 space-y-2">
                    <!-- Empty state will be shown when no items -->
                    <div id="emptyCartState" class="text-center py-8 text-gray-400">
                        <svg class="w-10 h-10 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        <p class="text-sm">Belum ada transaksi</p>
                    </div>
                </div>
                
                <!-- Cart Summary -->
                <form id="checkoutForm" method="POST" action="{{ route('sales.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="border-t border-gray-200 p-4 bg-white shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)]">
                        <div class="space-y-2 mb-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Subtotal</span>
                                <span id="cartSubtotal" class="font-medium">Rp 0</span>
                            </div>
                            <div class="flex justify-between text-lg font-semibold pt-2 border-t border-gray-100">
                                <span>Total</span>
                                <span id="cartTotal" class="text-teh-jawa-gold">Rp 0</span>
                            </div>
                        </div>
                        
                        <!-- Transaction Date & Payment Method -->
                        <div class="space-y-2 mb-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Tanggal Transaksi</label>
                                <input type="date" name="transaction_date" id="transactionDate" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-teh-jawa-gold focus:border-teh-jawa-gold">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Metode Pembayaran</label>
                                <select name="payment_method" id="paymentMethod" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-teh-jawa-gold focus:border-teh-jawa-gold">
                                    <option value="cash">Tunai</option>
                                    <option value="qris">QRIS</option>
                                    <option value="debit">Kartu Debit</option>
                                    <option value="credit">Kartu Kredit</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Catatan</label>
                                <input type="text" name="notes" id="saleNotes" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-teh-jawa-gold focus:border-teh-jawa-gold" placeholder="Catatan transaksi">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Upload Bukti (Nota/Kwitansi)</label>
                                <input type="file" name="receipt" id="receiptFile" accept="image/*,.pdf" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-teh-jawa-gold focus:border-teh-jawa-gold">
                                <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, atau PDF (Max: 2MB)</p>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="flex space-x-2">
                            <button type="button" id="clearCartBtn" class="flex-1 px-3 py-2 bg-gray-100 text-gray-700 rounded-md text-sm font-medium hover:bg-gray-200 transition-colors disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                                Kosongkan
                            </button>
                            <button type="button" id="checkoutBtn" class="flex-1 px-3 py-2 bg-gradient-to-r from-teh-jawa-gold to-teh-jawa-brown text-white rounded-md text-sm font-medium hover:from-teh-jawa-gold-dark hover:to-teh-jawa-brown-dark transition-all disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                                Simpan Transaksi
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Recent Sales Modal (Optional) -->
    <div class="fixed bottom-4 right-4 z-50">
        <button onclick="toggleRecentSales()" class="bg-white shadow-lg rounded-full p-3 hover:shadow-xl transition-shadow">
            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </button>
    </div>
</div>

@push('styles')
<style>
/* Professional POS Styles */
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Product Card Styles */
.menu-item-card {
    transition: all 0.2s ease;
}

.menu-item-card:hover {
    transform: translateY(-2px);
}

/* Quantity Selector Styles */
.quantity-selector-container {
    animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-5px); }
    to { opacity: 1; transform: translateY(0); }
}

.quick-add-buttons {
    display: flex;
    gap: 2px;
}

.quick-add-btn {
    transition: all 0.2s ease;
    border: 1px solid transparent;
}

.quick-add-btn:hover {
    border-color: #3b82f6;
    transform: translateY(-1px);
}

.quick-add-btn:active {
    transform: translateY(0);
}

.quantity-input {
    -moz-appearance: textfield;
}

.quantity-input::-webkit-outer-spin-button,
.quantity-input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

.quantity-input:focus {
    outline: none;
}

.quantity-decrease,
.quantity-increase {
    transition: all 0.2s ease;
}

.quantity-decrease:hover,
.quantity-increase:hover {
    background-color: #e5e7eb;
}

.add-to-cart-btn {
    transition: all 0.2s ease;
    white-space: nowrap;
}

.add-to-cart-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}

.add-to-cart-btn:active {
    transform: translateY(0);
}

/* Category Tabs */
.category-tab {
    transition: all 0.2s ease;
    position: relative;
}

.category-tab.active {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
}

.category-tab:not(.active):hover {
    background: #f3f4f6;
    color: #374151;
}

/* Cart Animations */
#cartCount {
    transition: all 0.3s ease;
}

#cartCount.animate-bounce {
    animation: bounce 0.5s ease;
}

@keyframes bounce {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.2); }
}

/* Custom Scrollbar */
.overflow-y-auto::-webkit-scrollbar {
    width: 6px;
}

.overflow-y-auto::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 3px;
}

.overflow-y-auto::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 3px;
}

.overflow-y-auto::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

/* Focus States */
.focus\:ring-2:focus {
    outline: none;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

/* Button States */
button:disabled {
    cursor: not-allowed;
    opacity: 0.5;
}

/* Fixed 4-Column Grid Layout */
#menuGrid {
    display: grid !important;
    grid-template-columns: repeat(4, minmax(0, 1fr)) !important;
    gap: 1rem !important;
    padding: 1rem !important;
}

/* Responsive adjustments */
@media (max-width: 1024px) {
    #menuGrid {
        grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
    }
}

@media (max-width: 768px) {
    #menuGrid {
        grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
    }
}

@media (max-width: 480px) {
    #menuGrid {
        grid-template-columns: repeat(1, minmax(0, 1fr)) !important;
    }
}

/* Consistent card sizing */
.menu-item-card {
    width: 100% !important;
    max-width: 100% !important;
    min-height: 280px !important;
    display: flex !important;
    flex-direction: column !important;
}

.menu-item-card > div {
    flex: 1 !important;
    display: flex !important;
    flex-direction: column !important;
}

.menu-item-card .p-3 {
    margin-top: auto !important;
}

/* Hide quick add buttons */
.quick-add-buttons {
    display: none !important;
}
@media (max-width: 640px) {
    .grid-cols-2 {
        grid-template-columns: repeat(1, 1fr);
    }
    
    .quick-add-buttons {
        flex-wrap: wrap;
    }
    
    .quick-add-btn {
        flex: 0 0 calc(50% - 1px);
    }
}

@media (min-width: 641px) and (max-width: 768px) {
    .grid-cols-3 {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (min-width: 769px) and (max-width: 1024px) {
    .grid-cols-4 {
        grid-template-columns: repeat(3, 1fr);
    }
    
    .grid-cols-5 {
        grid-template-columns: repeat(4, 1fr);
    }
}

@media (min-width: 1025px) and (max-width: 1280px) {
    .grid-cols-6 {
        grid-template-columns: repeat(5, 1fr);
    }
}

/* Mobile Layout Adjustments */
@media (max-width: 1024px) {
    .lg\:w-96 {
        width: 100%;
    }
    
    .flex-col.lg\:flex-row {
        flex-direction: column;
    }
    
    .h-\[calc\(100vh-4rem\)\] {
        height: auto;
        min-height: calc(100vh - 4rem);
    }
}

/* Loading States */
.loading {
    position: relative;
    overflow: hidden;
}

.loading::after {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.6), transparent);
    animation: loading 1.5s infinite;
}

@keyframes loading {
    0% { left: -100%; }
    100% { left: 100%; }
}

/* Success Animation */
.success-animation {
    animation: success 0.5s ease;
}

@keyframes success {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Set default transaction date to today
    const transactionDateInput = document.getElementById('transactionDate');
    if (transactionDateInput) {
        transactionDateInput.value = new Date().toISOString().split('T')[0];
    }
    
    // Initialize cart
    let cart = [];
    
    // Get CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    
    // Verify CSRF token exists
    if (!csrfToken) {
        console.error('❌ CSRF token not found!');
        alert('Security token not found. Please refresh the page and try again.');
        return;
    }
    
    console.log('✅ CSRF token found:', csrfToken.substring(0, 20) + '...');

    // SIMPLE TEST FUNCTION - Add this for debugging
    window.testCart = function() {
        console.log('🧪 Testing cart system...');
        
        // Test 1: Check if DOM elements exist
        const cartItemsContainer = document.getElementById('cartItems');
        const cartTotal = document.getElementById('cartTotal');
        const cartSubtotal = document.getElementById('cartSubtotal');
        const cartTax = document.getElementById('cartTax');
        const cartCount = document.getElementById('cartCount');
        
        console.log('🔍 DOM Elements:', {
            cartItems: !!cartItemsContainer,
            cartTotal: !!cartTotal,
            cartSubtotal: !!cartSubtotal,
            cartTax: !!cartTax,
            cartCount: !!cartCount
        });
        
        // Test 2: Try to add a test item manually
        console.log('🧪 Adding test item...');
        addToCart('test-123', 'Test Item', 10000, 2);
        
        // Test 3: Check cart state
        console.log('🧪 Cart state after test:', cart);
        
        // Test 4: Try to update cart manually
        console.log('🧪 Manually calling updateCart...');
        updateCart();
        
        return 'Test completed - check console';
    };
    
    // Debug: Check if elements exist
    const cartItemsContainer = document.getElementById('cartItems');
    const cartTotal = document.getElementById('cartTotal');
    const cartSubtotal = document.getElementById('cartSubtotal');
    const cartTax = document.getElementById('cartTax');
    const cartCount = document.getElementById('cartCount');
    
    console.log('🔍 DOM Elements Check:', {
        cartItemsContainer: !!cartItemsContainer,
        cartTotal: !!cartTotal,
        cartSubtotal: !!cartSubtotal,
        cartTax: !!cartTax,
        cartCount: !!cartCount
    });
    
    // Category filter
    const categoryTabs = document.querySelectorAll('.category-tab');
    const menuItems = document.querySelectorAll('.menu-item-card');
    
    console.log('📊 Category Tabs:', categoryTabs.length);
    console.log('📊 Menu Items:', menuItems.length);
    console.log('📊 Menu Grid exists:', !!document.getElementById('menuGrid'));
    
    // Debug: Check if menu items are in DOM
    const menuGrid = document.getElementById('menuGrid');
    if (menuGrid) {
        console.log('📊 Menu Grid children:', menuGrid.children.length);
        console.log('📊 Menu Grid HTML:', menuGrid.innerHTML.substring(0, 200) + '...');
    } else {
        console.error('❌ Menu Grid not found!');
    }
    
    categoryTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const category = this.dataset.category;
            console.log('🏷️ Category clicked:', category);
            
            // Update active tab
            categoryTabs.forEach(t => {
                t.classList.remove('active', 'bg-blue-600', 'text-white');
                t.classList.add('bg-gray-100', 'text-gray-700');
            });
            this.classList.remove('bg-gray-100', 'text-gray-700');
            this.classList.add('active', 'bg-blue-600', 'text-white');
            
            // Filter menu items
            menuItems.forEach(item => {
                if (category === 'all' || item.dataset.category === category) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
    
    // Add to cart - Simplified event handling
    document.addEventListener('click', function(e) {
        console.log('🖱️ Click detected on:', e.target.className, e.target.tagName);
        
        // Handle Quick Add Buttons
        if (e.target.classList.contains('quick-add-btn') || e.target.closest('.quick-add-btn')) {
            console.log('🔘 Quick Add button clicked');
            e.preventDefault();
            e.stopPropagation();
            
            const quickAddBtn = e.target.classList.contains('quick-add-btn') ? e.target : e.target.closest('.quick-add-btn');
            const menuCard = quickAddBtn.closest('.menu-item-card');
            const quantity = parseInt(quickAddBtn.dataset.quantity);
            
            console.log('🔍 Quick Add data:', { menuCard: !!menuCard, quantity });
            
            if (menuCard) {
                const menuId = menuCard.dataset.menuId;
                const menuName = menuCard.dataset.menuName;
                const menuPrice = parseFloat(menuCard.dataset.menuPrice);
                
                console.log('📦 Quick Add data from card:', { menuId, menuName, menuPrice, quantity });
                
                addToCart(menuId, menuName, menuPrice, quantity);
                
                // Visual feedback
                quickAddBtn.classList.add('bg-blue-600', 'text-white');
                setTimeout(() => {
                    quickAddBtn.classList.remove('bg-blue-600', 'text-white');
                }, 300);
                
                // Add success animation to card
                menuCard.classList.add('success-animation');
                setTimeout(() => {
                    menuCard.classList.remove('success-animation');
                }, 500);
            }
            return;
        }
        
        // Handle Add Button with custom quantity
        if (e.target.classList.contains('add-to-cart-btn') || e.target.closest('.add-to-cart-btn')) {
            console.log('➕ Add button clicked');
            e.preventDefault();
            e.stopPropagation();
            
            const addBtn = e.target.classList.contains('add-to-cart-btn') ? e.target : e.target.closest('.add-to-cart-btn');
            const menuCard = addBtn.closest('.menu-item-card');
            
            console.log('🔍 Add button data:', { menuCard: !!menuCard });
            
            if (menuCard) {
                const menuId = menuCard.dataset.menuId;
                const menuName = menuCard.dataset.menuName;
                const menuPrice = parseFloat(menuCard.dataset.menuPrice);
                const quantityInput = menuCard.querySelector('.quantity-input');
                const quantity = parseInt(quantityInput.value) || 1;
                
                console.log('📦 Add button data from card:', { menuId, menuName, menuPrice, quantity });
                
                addToCart(menuId, menuName, menuPrice, quantity);
                
                // Visual feedback
                addBtn.style.transform = 'scale(0.9)';
                setTimeout(() => {
                    addBtn.style.transform = '';
                }, 150);
                
                // Add success animation to card
                menuCard.classList.add('success-animation');
                setTimeout(() => {
                    menuCard.classList.remove('success-animation');
                }, 500);
                
                // Reset quantity to 1 after adding
                quantityInput.value = 1;
            }
            return;
        }
        
        // Handle Quantity Decrease
        if (e.target.classList.contains('quantity-decrease') || e.target.closest('.quantity-decrease')) {
            console.log('➖ Decrease button clicked');
            e.preventDefault();
            e.stopPropagation();
            
            const decreaseBtn = e.target.classList.contains('quantity-decrease') ? e.target : e.target.closest('.quantity-decrease');
            const input = decreaseBtn.parentElement.querySelector('.quantity-input');
            const currentValue = parseInt(input.value) || 1;
            if (currentValue > 1) {
                input.value = currentValue - 1;
                console.log('📉 Quantity decreased to:', input.value);
            }
            return;
        }
        
        // Handle Quantity Increase
        if (e.target.classList.contains('quantity-increase') || e.target.closest('.quantity-increase')) {
            console.log('➕ Increase button clicked');
            e.preventDefault();
            e.stopPropagation();
            
            const increaseBtn = e.target.classList.contains('quantity-increase') ? e.target : e.target.closest('.quantity-increase');
            const input = increaseBtn.parentElement.querySelector('.quantity-input');
            const currentValue = parseInt(input.value) || 1;
            if (currentValue < 99) {
                input.value = currentValue + 1;
                console.log('📈 Quantity increased to:', input.value);
            }
            return;
        }
        
        // Handle Card Click (for adding 1 item)
        if (e.target.closest('.menu-item-card') && 
            !e.target.closest('.add-to-cart-btn') && 
            !e.target.closest('.quick-add-btn') && 
            !e.target.closest('.quantity-decrease') && 
            !e.target.closest('.quantity-increase') && 
            !e.target.closest('.quantity-input')) {
            
            console.log('🃏 Card click detected');
            const menuCard = e.target.closest('.menu-item-card');
            const menuId = menuCard.dataset.menuId;
            const menuName = menuCard.dataset.menuName;
            const menuPrice = parseFloat(menuCard.dataset.menuPrice);
            
            console.log('🃏 Card click data:', { menuId, menuName, menuPrice });
            
            addToCart(menuId, menuName, menuPrice, 1);
            
            // Visual feedback
            menuCard.classList.add('success-animation');
            setTimeout(() => {
                menuCard.classList.remove('success-animation');
            }, 500);
        }
    });
    
    // Handle quantity input validation
    document.addEventListener('input', function(e) {
        if (e.target.classList.contains('quantity-input')) {
            const value = parseInt(e.target.value) || 1;
            if (value < 1) {
                e.target.value = 1;
            } else if (value > 99) {
                e.target.value = 99;
            }
        }
    });
        
    function addToCart(id, name, price, quantity = 1) {
        console.log('🛒 addToCart called:', { id, name, price, quantity });
        console.log('🛒 Current cart:', cart);
        
        // Validate inputs
        if (!id || !name || isNaN(price) || isNaN(quantity) || quantity < 1) {
            console.error('❌ Invalid input:', { id, name, price, quantity });
            return;
        }
        
        const existingItem = cart.find(item => item.id === id);
        
        if (existingItem) {
            existingItem.quantity += quantity;
            console.log('📝 Updated existing item:', existingItem);
        } else {
            const newItem = {
                id: id,
                name: name,
                price: parseFloat(price),
                quantity: parseInt(quantity)
            };
            cart.push(newItem);
            console.log('➕ Added new item:', newItem);
        }
        
        console.log('🛒 Cart after update:', cart);
        updateCart();
    }
    
    window.removeFromCart = function(id) {
        cart = cart.filter(item => item.id !== id);
        updateCart();
    }

    window.updateQuantity = function(id, newQuantity) {
        if (newQuantity <= 0) {
            removeFromCart(id);
            return;
        }
        
        const item = cart.find(item => item.id === id);
        if (item) {
            item.quantity = newQuantity;
            updateCart();
        }
    }
    
    function updateCart() {
        console.log('🔄 updateCart called');
        console.log('🔄 Current cart state:', cart);
        
        const cartItemsContainer = document.getElementById('cartItems');
        const cartTotal = document.getElementById('cartTotal');
        const cartSubtotal = document.getElementById('cartSubtotal');
        const cartCount = document.getElementById('cartCount');
        const clearCartBtn = document.getElementById('clearCartBtn');
        const checkoutBtn = document.getElementById('checkoutBtn');
        
        console.log('🔍 DOM Elements in updateCart:', {
            cartItemsContainer: !!cartItemsContainer,
            cartTotal: !!cartTotal,
            cartSubtotal: !!cartSubtotal,
            cartCount: !!cartCount,
            clearCartBtn: !!clearCartBtn,
            checkoutBtn: !!checkoutBtn
        });
        
        if (cart.length === 0) {
            console.log('📦 Cart is empty');
            cartItemsContainer.innerHTML = `
                <div class="text-center py-8 text-gray-400">
                    <svg class="w-10 h-10 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <p class="text-sm font-medium">Belum ada transaksi</p>
                    <p class="text-xs mt-1">Pilih produk untuk memulai</p>
                </div>
            `;
            
            const subtotal = 0;
            const total = 0;
            const itemCount = 0;
            
            cartSubtotal.textContent = 'Rp ' + number_format(subtotal, 0);
            cartTotal.textContent = 'Rp ' + number_format(total, 0);
            cartCount.textContent = itemCount;
            clearCartBtn.disabled = true;
            checkoutBtn.disabled = true;
        } else {
            console.log('📦 Cart has items:', cart.length);
            let html = '';
            let subtotal = 0;
            let itemCount = 0;
            
            cart.forEach((item, index) => {
                const itemTotal = item.price * item.quantity;
                subtotal += itemTotal;
                itemCount += item.quantity;
                
                console.log(`📋 Item ${index}:`, { 
                    name: item.name, 
                    price: item.price, 
                    quantity: item.quantity, 
                    total: itemTotal 
                });
                
                html += `
                    <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-b-0">
                        <div class="flex-1">
                            <p class="font-medium text-sm text-gray-900">${item.name}</p>
                            <p class="text-xs text-gray-500">Rp ${number_format(item.price, 0)} × ${item.quantity}</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="flex items-center bg-gray-100 rounded-lg">
                                <button onclick="updateQuantity('${item.id}', ${item.quantity - 1})" 
                                        class="p-1.5 hover:bg-gray-200 rounded-l-lg transition-colors ${item.quantity <= 1 ? 'opacity-50 cursor-not-allowed' : ''}"
                                        ${item.quantity <= 1 ? 'disabled' : ''}>
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                    </svg>
                                </button>
                                <span class="px-3 py-1 text-sm font-medium w-8 text-center">${item.quantity}</span>
                                <button onclick="updateQuantity('${item.id}', ${item.quantity + 1})" 
                                        class="p-1.5 hover:bg-gray-200 rounded-r-lg transition-colors">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                </button>
                            </div>
                            <button onclick="removeFromCart('${item.id}')" class="text-red-500 hover:text-red-700 p-1.5 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                `;
            });
            
            cartItemsContainer.innerHTML = html;
            
            const total = subtotal;
            
            console.log('💰 Calculated totals:', { subtotal, total, itemCount });
            
            cartSubtotal.textContent = 'Rp ' + number_format(subtotal, 0);
            cartTotal.textContent = 'Rp ' + number_format(total, 0);
            cartCount.textContent = itemCount;
            clearCartBtn.disabled = false;
            checkoutBtn.disabled = false;
            
            // Add animation
            cartCount.classList.add('animate-bounce');
            setTimeout(() => {
                cartCount.classList.remove('animate-bounce');
            }, 500);
        }
    }
    
    
    // Checkout process - COMPLETELY REBUILT
    const checkoutBtn = document.getElementById('checkoutBtn');
    const checkoutForm = document.getElementById('checkoutForm');
    const clearCartBtn = document.getElementById('clearCartBtn');
    
    console.log('🔧 Initializing checkout system...');
    console.log('📋 Form element:', !!checkoutForm);
    console.log('🔘 Checkout button:', !!checkoutBtn);
    console.log('🗑️ Clear button:', !!clearCartBtn);
    console.log('🔐 CSRF token:', csrfToken ? '✅ Found' : '❌ Missing');
    
    // Clear cart functionality
    if (clearCartBtn) {
        clearCartBtn.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('🗑️ Clear cart clicked');
            
            if (confirm('Apakah Anda yakin ingin mengosongkan transaksi?')) {
                cart = [];
                updateCart();
                console.log('✅ Cart cleared');
            }
        });
    }
    
    // MAIN CHECKOUT FUNCTIONALITY
    if (checkoutBtn && checkoutForm) {
        checkoutBtn.addEventListener('click', async function(e) {
            console.log('🚀 CHECKOUT PROCESS STARTED');
            e.preventDefault();
            
            // Step 1: Validate cart
            if (!cart || cart.length === 0) {
                console.error('❌ Cart is empty');
                alert('ERROR: Keranjang belanja masih kosong! Silakan tambahkan produk terlebih dahulu.');
                return;
            }
            console.log('✅ Cart validation passed - Items:', cart.length);
            
            // Step 2: Get form elements
            const transactionDateInput = document.getElementById('transactionDate');
            const paymentMethodSelect = document.getElementById('paymentMethod');
            const saleNotesInput = document.getElementById('saleNotes');
            const receiptFileInput = document.getElementById('receiptFile');
            
            console.log('📝 Form elements:', {
                transactionDate: !!transactionDateInput,
                paymentMethod: !!paymentMethodSelect,
                saleNotes: !!saleNotesInput,
                receiptFile: !!receiptFileInput
            });
            
            // Step 3: Get form values with validation
            const transactionDate = transactionDateInput?.value || new Date().toISOString().split('T')[0];
            const paymentMethod = paymentMethodSelect?.value || 'cash';
            const saleNotes = saleNotesInput?.value || '';
            const receiptFile = receiptFileInput?.files[0] || null;
            
            console.log('📋 Form data collected:', {
                transactionDate,
                paymentMethod,
                saleNotes,
                receiptFile: receiptFile ? receiptFile.name : 'none'
            });
            
            // Step 4: Calculate totals
            let subtotal = 0;
            let itemCount = 0;
            const orderItems = cart.map(item => {
                const itemTotal = item.price * item.quantity;
                subtotal += itemTotal;
                itemCount += item.quantity;
                return {
                    menu_item_id: item.id,
                    quantity: item.quantity,
                    notes: null
                };
            });
            
            const total = subtotal;
            
            console.log('💰 Calculation results:', {
                itemCount,
                subtotal,
                total,
                orderItems
            });
            
            // Step 5: Create FormData
            const formData = new FormData();
            formData.append('items', JSON.stringify(orderItems));
            formData.append('transaction_date', transactionDate);
            formData.append('payment_method', paymentMethod);
            formData.append('notes', saleNotes);
            formData.append('subtotal', subtotal);
            formData.append('total', total);
            formData.append('item_count', itemCount);
            
            if (receiptFile) {
                formData.append('receipt', receiptFile);
                console.log('📎 Receipt file added:', receiptFile.name);
            }
            
            // Debug: Log FormData contents
            console.log('📋 FormData contents:');
            for (let [key, value] of formData.entries()) {
                if (key === 'items') {
                    console.log(`  ${key}:`, JSON.parse(value));
                } else if (key === 'receipt') {
                    console.log(`  ${key}:`, value.name, 'Size:', value.size);
                } else {
                    console.log(`  ${key}:`, value);
                }
            }
            
            // Step 6: Validate CSRF token
            if (!csrfToken) {
                console.error('❌ CSRF token missing');
                alert('ERROR: Security token tidak ditemukan. Silakan refresh halaman.');
                return;
            }
            
            console.log('🔐 CSRF token validated');
            console.log('📦 FormData prepared, sending to server...');
            
            // Step 7: Show loading state
            const originalText = this.innerHTML;
            this.disabled = true;
            this.innerHTML = '⏳ Memproses...';
            this.classList.add('opacity-75', 'cursor-not-allowed');
            
            try {
                // Step 8: Send request
                const response = await fetch('/sales', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: formData
                });
                
                console.log('📡 Server response status:', response.status);
                console.log('📡 Response headers:', Object.fromEntries(response.headers.entries()));
                
                // Step 9: Process response
                if (!response.ok) {
                    const errorText = await response.text();
                    console.error('❌ Server error response:', errorText);
                    throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                }
                
                const data = await response.json();
                console.log('✅ Success response:', data);
                
                // Step 10: Handle success
                if (data.success) {
                    console.log('✅ SUCCESS - Transaction data:', data);
                    
                    // Show detailed success notification
                    const successMessage = `✅ Transaksi BERHASIL disimpan!\n\n` +
                        `📝 ID: ${data.transaction_id}\n` +
                        `💰 Total: Rp ${number_format(data.total_amount || total, 0)}\n` +
                        `📅 Tanggal: ${data.transaction_date || transactionDate}\n` +
                        `💳 Metode: ${data.payment_method || paymentMethod}\n` +
                        `📋 Deskripsi: ${data.description || 'Penjualan Menu'}\n\n` +
                        `✅ Data telah masuk ke tabel transaksi PEMASUKAN`;
                    
                    alert(successMessage);
                    
                    // Clear cart
                    cart = [];
                    updateCart();
                    
                    // Reset form
                    if (transactionDateInput) transactionDateInput.value = new Date().toISOString().split('T')[0];
                    if (paymentMethodSelect) paymentMethodSelect.value = 'cash';
                    if (saleNotesInput) saleNotesInput.value = '';
                    if (receiptFileInput) receiptFileInput.value = '';
                    
                    console.log('🔄 Form and cart reset');
                    console.log('💰 Transaction data saved to INCOME table');
                    console.log('📊 Transaction ID:', data.transaction_id);
                    console.log('💵 Amount:', data.total_amount);
                    console.log('📝 Type:', data.type);
                    
                    // Redirect to transactions page to show the data
                    setTimeout(() => {
                        const redirectUrl = '/transactions';
                        console.log('🔀 Redirecting to transactions page:', redirectUrl);
                        window.location.href = redirectUrl;
                    }, 2000);
                    
                } else {
                    console.error('❌ Server returned error:', data.message);
                    alert(`❌ ERROR: ${data.message || 'Terjadi kesalahan pada server'}`);
                }
                
            } catch (error) {
                console.error('💥 FETCH ERROR:', error);
                alert(`❌ ERROR: ${error.message}\n\nSilakan coba lagi atau hubungi admin.`);
                
            } finally {
                // Step 11: Reset button state
                this.disabled = false;
                this.innerHTML = originalText;
                this.classList.remove('opacity-75', 'cursor-not-allowed');
                console.log('🔄 Button state reset');
            }
        });
        
        console.log('✅ Checkout event listener attached successfully');
        
    } else {
        console.error('❌ Missing required elements:', {
            checkoutBtn: !!checkoutBtn,
            checkoutForm: !!checkoutForm
        });
    }
    // Helper function for number formatting
    function number_format(number, decimals) {
        return number.toLocaleString('id-ID', {
            minimumFractionDigits: decimals,
            maximumFractionDigits: decimals
        });
    }
    
    // Optional: Recent sales modal function
    function toggleRecentSales() {
        // Implementation for recent sales modal
        console.log('Toggle recent sales modal');
    }
});
</script>
@endpush
@endsection
