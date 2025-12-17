@extends('layouts.app')

@section('content')
<style>
/* Teh Jawa Brand Colors */
:root {
    --tj-gold: #D4AF37;
    --tj-gold-dark: #B8941F;
    --tj-brown: #8B4513;
    --tj-cream: #FFF8E7;
    --tj-green: #4A7C28;
}

.pos-container {
    display: flex;
    height: calc(100vh - 64px);
    background: linear-gradient(135deg, #FFF8E7 0%, #F4E4B1 100%);
}

/* Left Panel */
.pos-left {
    flex: 1;
    display: flex;
    flex-direction: column;
    padding: 24px;
    overflow: hidden;
}

.pos-title {
    font-size: 24px;
    font-weight: 700;
    color: #1e293b;
    margin: 0 0 20px 0;
}

/* Menu Dropdown */
.menu-dropdown-container {
    position: relative;
    margin-bottom: 20px;
}

.menu-dropdown-trigger {
    width: 100%;
    padding: 14px 16px;
    background: white;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    font-size: 15px;
    text-align: left;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: space-between;
    transition: all 0.2s;
}

.menu-dropdown-trigger:hover,
.menu-dropdown-trigger:focus {
    border-color: var(--tj-gold);
    outline: none;
}

.menu-dropdown-trigger svg {
    transition: transform 0.2s;
}

.menu-dropdown-trigger.open svg {
    transform: rotate(180deg);
}

.menu-dropdown-list {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: white;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    margin-top: 4px;
    max-height: 400px;
    overflow-y: auto;
    z-index: 100;
    display: none;
    box-shadow: 0 10px 40px rgba(0,0,0,0.15);
}

.menu-dropdown-list.open {
    display: block;
}

.menu-dropdown-search {
    padding: 12px;
    border-bottom: 1px solid #e2e8f0;
    position: sticky;
    top: 0;
    background: white;
}

.menu-dropdown-search input {
    width: 100%;
    padding: 10px 14px;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-size: 14px;
}

.menu-dropdown-search input:focus {
    outline: none;
    border-color: var(--tj-gold);
}

.menu-dropdown-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 14px;
    cursor: pointer;
    transition: background 0.15s;
    border-bottom: 1px solid #f1f5f9;
}

.menu-dropdown-item:hover {
    background: var(--tj-cream);
}

.menu-dropdown-item:last-child {
    border-bottom: none;
}

.menu-dropdown-item.unavailable {
    opacity: 0.5;
    pointer-events: none;
}

.menu-dropdown-img {
    width: 50px;
    height: 50px;
    border-radius: 8px;
    object-fit: cover;
    background: #f1f5f9;
    flex-shrink: 0;
}

.menu-dropdown-img-placeholder {
    width: 50px;
    height: 50px;
    border-radius: 8px;
    background: #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.menu-dropdown-info {
    flex: 1;
    min-width: 0;
}

.menu-dropdown-name {
    font-size: 14px;
    font-weight: 600;
    color: #1e293b;
    margin: 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.menu-dropdown-category {
    font-size: 11px;
    color: #64748b;
    margin: 2px 0 0 0;
    text-transform: uppercase;
}

.menu-dropdown-price {
    font-size: 14px;
    font-weight: 700;
    color: var(--tj-gold);
    white-space: nowrap;
    margin-right: 8px;
}

.menu-dropdown-edit {
    width: 32px;
    height: 32px;
    background: var(--tj-brown);
    border: none;
    border-radius: 6px;
    color: white;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    transition: all 0.15s;
}

.menu-dropdown-edit:hover {
    background: #6d3710;
    transform: scale(1.05);
}

/* Selected Menu Preview */
.selected-menu {
    background: white;
    border-radius: 16px;
    padding: 20px;
    display: none;
    margin-bottom: 20px;
    border: 2px solid #e2e8f0;
}

.selected-menu.show {
    display: block;
}

.selected-menu-content {
    display: flex;
    gap: 16px;
}

.selected-menu-img {
    width: 120px;
    height: 120px;
    border-radius: 12px;
    object-fit: cover;
    background: #f1f5f9;
    flex-shrink: 0;
}

.selected-menu-info {
    flex: 1;
}

.selected-menu-name {
    font-size: 20px;
    font-weight: 700;
    color: #1e293b;
    margin: 0 0 4px 0;
}

.selected-menu-category {
    font-size: 12px;
    color: #64748b;
    text-transform: uppercase;
    margin: 0 0 8px 0;
}

.selected-menu-price {
    font-size: 24px;
    font-weight: 700;
    color: var(--tj-gold);
    margin: 0 0 12px 0;
}

.selected-menu-actions {
    display: flex;
    gap: 10px;
    align-items: center;
}

.qty-control {
    display: flex;
    align-items: center;
    gap: 8px;
    background: #f1f5f9;
    border-radius: 10px;
    padding: 6px;
}

.qty-control button {
    width: 36px;
    height: 36px;
    border: none;
    background: white;
    border-radius: 8px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    transition: all 0.15s;
}

.qty-control button:hover {
    background: #e2e8f0;
}

.qty-control span {
    width: 40px;
    text-align: center;
    font-weight: 700;
    font-size: 16px;
}

.btn-add-cart {
    flex: 1;
    height: 48px;
    background: linear-gradient(135deg, var(--tj-gold) 0%, var(--tj-brown) 100%);
    color: white;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: all 0.2s;
}

.btn-add-cart:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(212, 175, 55, 0.4);
}

.btn-edit-menu {
    height: 48px;
    padding: 0 20px;
    background: var(--tj-brown);
    color: white;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-edit-menu:hover {
    background: #6d3710;
}

/* Header Buttons */
.header-actions {
    display: flex;
    gap: 12px;
    margin-bottom: 20px;
}

.btn-primary {
    height: 44px;
    padding: 0 20px;
    background: linear-gradient(135deg, var(--tj-gold) 0%, var(--tj-brown) 100%);
    color: white;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: all 0.2s;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(212, 175, 55, 0.4);
}

/* Right Panel - Cart */
.pos-right {
    width: 400px;
    background: white;
    border-left: 1px solid #e2e8f0;
    display: flex;
    flex-direction: column;
}

.cart-header {
    padding: 20px;
    background: linear-gradient(135deg, var(--tj-brown) 0%, #6d3710 100%);
    color: white;
}

.cart-header h2 {
    font-size: 20px;
    font-weight: 700;
    margin: 0;
}

.cart-header p {
    font-size: 13px;
    opacity: 0.7;
    margin: 4px 0 0 0;
}

.cart-items {
    flex: 1;
    overflow-y: auto;
    padding: 16px;
}

.cart-empty {
    text-align: center;
    padding: 60px 20px;
    color: #94a3b8;
}

.cart-item {
    background: #f8fafc;
    border-radius: 12px;
    padding: 14px;
    margin-bottom: 12px;
}

.cart-item-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 10px;
}

.cart-item-name {
    font-weight: 600;
    color: #1e293b;
    font-size: 14px;
}

.cart-item-remove {
    color: #ef4444;
    background: none;
    border: none;
    cursor: pointer;
    padding: 4px;
}

.cart-item-details {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.cart-item-qty {
    display: flex;
    align-items: center;
    gap: 6px;
    background: white;
    border-radius: 8px;
    padding: 4px;
}

.cart-item-qty button {
    width: 28px;
    height: 28px;
    border: none;
    background: #f1f5f9;
    border-radius: 6px;
    cursor: pointer;
}

.cart-item-qty span {
    width: 24px;
    text-align: center;
    font-weight: 600;
}

.cart-item-total {
    font-weight: 700;
    color: #1e293b;
}

.cart-footer {
    padding: 20px;
    border-top: 1px solid #e2e8f0;
    background: #f8fafc;
}

.cart-total {
    display: flex;
    justify-content: space-between;
    font-size: 20px;
    font-weight: 700;
    margin-bottom: 16px;
    color: #1e293b;
}

.cart-total span:last-child {
    color: var(--tj-gold);
}

.cart-form {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-bottom: 16px;
}

.cart-form input,
.cart-form select,
.cart-form textarea {
    width: 100%;
    height: 44px;
    padding: 0 14px;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    font-size: 14px;
}

.cart-form textarea {
    height: 60px;
    padding: 12px 14px;
    resize: none;
}

.cart-actions {
    display: flex;
    gap: 10px;
}

.btn-clear {
    flex: 1;
    height: 48px;
    border: 2px solid #e2e8f0;
    background: white;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
}

.btn-checkout {
    flex: 2;
    height: 48px;
    background: linear-gradient(135deg, var(--tj-gold) 0%, var(--tj-brown) 100%);
    color: white;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.btn-checkout:hover {
    box-shadow: 0 6px 20px rgba(212, 175, 55, 0.4);
}

/* Modal */
.modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.5);
    backdrop-filter: blur(4px);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 1000;
    padding: 16px;
}

.modal-overlay.active {
    display: flex;
}

.modal {
    background: white;
    border-radius: 12px;
    width: 100%;
    max-width: 420px;
    max-height: 85vh;
    overflow: hidden;
    box-shadow: 0 20px 40px rgba(0,0,0,0.2);
}

.modal-header {
    padding: 16px 20px;
    background: linear-gradient(135deg, var(--tj-gold) 0%, var(--tj-brown) 100%);
    color: white;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.modal-header.edit {
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
}

.modal-header h3 {
    font-size: 16px;
    font-weight: 600;
    margin: 0;
}

.modal-close {
    width: 32px;
    height: 32px;
    background: rgba(255,255,255,0.2);
    border: none;
    border-radius: 6px;
    color: white;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.2s;
}

.modal-close:hover {
    background: rgba(255,255,255,0.3);
}

.modal-body {
    padding: 20px;
    overflow-y: auto;
    max-height: calc(85vh - 120px);
}

.form-group {
    margin-bottom: 14px;
}

.form-label {
    display: block;
    font-size: 12px;
    font-weight: 600;
    color: #4b5563;
    margin-bottom: 5px;
}

.form-input {
    width: 100%;
    height: 40px;
    padding: 0 12px;
    border: 1.5px solid #e5e7eb;
    border-radius: 8px;
    font-size: 14px;
    transition: border-color 0.2s;
}

.form-input:focus {
    outline: none;
    border-color: var(--tj-gold);
    box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.1);
}

.form-input::placeholder {
    color: #9ca3af;
}

.form-textarea {
    height: 70px;
    padding: 10px 12px;
    resize: none;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
}

.form-hint {
    font-size: 11px;
    color: #9ca3af;
    margin-top: 4px;
}

.form-checkbox {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 12px;
    background: #f9fafb;
    border-radius: 8px;
    cursor: pointer;
    transition: background 0.2s;
}

.form-checkbox:hover {
    background: #f3f4f6;
}

.form-checkbox input {
    width: 18px;
    height: 18px;
    accent-color: var(--tj-gold);
}

.form-checkbox span {
    font-size: 13px;
    color: #374151;
}

.form-stock-row {
    display: flex;
    align-items: center;
    gap: 10px;
}

.form-stock-row .form-input {
    flex: 1;
}

.modal-footer {
    padding: 14px 20px;
    background: #f9fafb;
    display: flex;
    gap: 10px;
    border-top: 1px solid #e5e7eb;
}

.btn-cancel {
    flex: 1;
    height: 40px;
    border: 1.5px solid #e5e7eb;
    background: white;
    border-radius: 8px;
    font-weight: 600;
    font-size: 13px;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-cancel:hover {
    background: #f3f4f6;
}

.btn-submit {
    flex: 1;
    height: 40px;
    border: none;
    background: linear-gradient(135deg, var(--tj-gold) 0%, var(--tj-brown) 100%);
    color: white;
    border-radius: 8px;
    font-weight: 600;
    font-size: 13px;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-submit:hover {
    box-shadow: 0 4px 12px rgba(212, 175, 55, 0.3);
}

.btn-delete {
    height: 40px;
    padding: 0 14px;
    border: none;
    background: #ef4444;
    color: white;
    border-radius: 8px;
    font-weight: 600;
    font-size: 13px;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-delete:hover {
    background: #dc2626;
}
</style>

<div class="pos-container">
    <!-- Left Panel -->
    <div class="pos-left">
        <h1 class="pos-title">Point of Sale</h1>
        
        <!-- Action Buttons -->
        <div class="header-actions">
            <button class="btn-primary" onclick="openAddModal()">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Menu
            </button>
        </div>

        <!-- Menu Dropdown -->
        <div class="menu-dropdown-container">
            <button type="button" class="menu-dropdown-trigger" id="menuDropdownTrigger" onclick="toggleDropdown()">
                <span>Pilih Menu...</span>
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div class="menu-dropdown-list" id="menuDropdownList">
                <div class="menu-dropdown-search">
                    <input type="text" id="menuSearch" placeholder="Cari menu..." oninput="filterMenu()">
                </div>
                @foreach($menuItems as $item)
                <div class="menu-dropdown-item {{ !$item->is_available ? 'unavailable' : '' }}" 
                     data-id="{{ $item->id }}"
                     data-name="{{ e($item->name) }}"
                     data-price="{{ $item->price }}"
                     data-category="{{ e($categoryLabels[$item->category] ?? $item->category) }}"
                     data-image="{{ $item->image ? asset('storage/'.$item->image) : '' }}">
                    @if($item->image)
                        <img src="{{ asset('storage/'.$item->image) }}" class="menu-dropdown-img" loading="lazy" onclick="selectMenu(this.parentElement)">
                    @else
                        <div class="menu-dropdown-img-placeholder" onclick="selectMenu(this.parentElement)">
                            <svg width="20" height="20" fill="none" stroke="#cbd5e1" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    @endif
                    <div class="menu-dropdown-info" onclick="selectMenu(this.parentElement)">
                        <p class="menu-dropdown-name">{{ $item->name }}</p>
                        <p class="menu-dropdown-category">{{ $categoryLabels[$item->category] ?? $item->category }}</p>
                    </div>
                    <span class="menu-dropdown-price" onclick="selectMenu(this.parentElement)">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                    <button type="button" class="menu-dropdown-edit" onclick="event.stopPropagation(); openEditModal({{ $item->id }})" title="Edit Menu">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </button>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Selected Menu Preview -->
        <div class="selected-menu" id="selectedMenu">
            <div class="selected-menu-content">
                <img src="" id="selectedImg" class="selected-menu-img">
                <div class="selected-menu-info">
                    <h3 class="selected-menu-name" id="selectedName">-</h3>
                    <p class="selected-menu-category" id="selectedCategory">-</p>
                    <p class="selected-menu-price" id="selectedPrice">Rp 0</p>
                    <div class="selected-menu-actions">
                        <div class="qty-control">
                            <button type="button" onclick="changeQty(-1)">−</button>
                            <span id="selectedQty">1</span>
                            <button type="button" onclick="changeQty(1)">+</button>
                        </div>
                        <button type="button" class="btn-add-cart" onclick="addSelectedToCart()">
                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            Tambah ke Keranjang
                        </button>
                        <button type="button" class="btn-edit-menu" onclick="editSelectedMenu()">Edit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Panel - Cart -->
    <div class="pos-right">
        <div class="cart-header">
            <h2>🛒 Keranjang</h2>
            <p id="cartCount">0 item</p>
        </div>

        <div class="cart-items" id="cartItems">
            <div class="cart-empty">
                <p>Keranjang kosong</p>
                <p style="font-size: 13px;">Pilih menu untuk menambahkan</p>
            </div>
        </div>

        <div class="cart-footer">
            <div class="cart-total">
                <span>Total</span>
                <span id="cartTotal">Rp 0</span>
            </div>

            <form id="checkoutForm" class="cart-form" enctype="multipart/form-data">
                <input type="date" name="transaction_date" value="{{ date('Y-m-d') }}" required>
                <select name="payment_method" required>
                    <option value="">Metode Pembayaran</option>
                    <option value="Tunai">Tunai</option>
                    <option value="QRIS">QRIS</option>
                    <option value="Transfer">Transfer Bank</option>
                    <option value="Debit">Kartu Debit</option>
                </select>
                <textarea name="notes" placeholder="Catatan (opsional)"></textarea>
                <div style="position: relative;">
                    <input type="file" name="receipt" id="receiptInput" accept="image/*,.pdf" style="display: none;">
                    <button type="button" onclick="document.getElementById('receiptInput').click()" style="width: 100%; height: 44px; border: 1px dashed #e2e8f0; background: #f8fafc; border-radius: 10px; font-size: 14px; color: #64748b; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px;">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span id="receiptLabel">Upload Bukti/Struk</span>
                    </button>
                </div>
            </form>

            <div class="cart-actions">
                <button type="button" class="btn-clear" onclick="clearCart()">Hapus</button>
                <button type="button" class="btn-checkout" onclick="checkout()" id="checkoutBtn">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Proses
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Add Menu Modal -->
<div class="modal-overlay" id="addModal">
    <div class="modal">
        <div class="modal-header">
            <h3>➕ Tambah Menu Baru</h3>
            <button class="modal-close" onclick="closeAddModal()">✕</button>
        </div>
        <form id="addMenuForm">
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Nama Menu *</label>
                    <input type="text" name="name" class="form-input" placeholder="Contoh: Nasi Goreng Special" required>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Kategori *</label>
                        <select name="category" class="form-input" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($categoryLabels as $val => $label)
                                <option value="{{ $val }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Harga (Rp) *</label>
                        <input type="number" name="price" class="form-input" placeholder="0" required min="0">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" class="form-input form-textarea" placeholder="Deskripsi menu (opsional)"></textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">Stok</label>
                    <div class="form-stock-row">
                        <input type="number" name="stock" id="addStock" class="form-input" placeholder="Jumlah stok" min="0" value="">
                    </div>
                    <label class="form-checkbox" style="margin-top: 8px;">
                        <input type="checkbox" id="addUnlimitedStock" onchange="toggleAddStock()" checked>
                        <span>Stok tidak terbatas</span>
                    </label>
                </div>
                <div class="form-group">
                    <label class="form-label">Gambar</label>
                    <input type="file" name="image" class="form-input" accept="image/*" style="padding: 8px;">
                </div>
                <label class="form-checkbox">
                    <input type="checkbox" name="is_available" value="1" checked>
                    <span>Menu tersedia untuk dijual</span>
                </label>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeAddModal()">Batal</button>
                <button type="submit" class="btn-submit">💾 Simpan Menu</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Menu Modal -->
<div class="modal-overlay" id="editModal">
    <div class="modal">
        <div class="modal-header edit">
            <h3>✏️ Edit Menu</h3>
            <button class="modal-close" onclick="closeEditModal()">✕</button>
        </div>
        <form id="editMenuForm">
            <input type="hidden" name="id" id="editId">
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Nama Menu *</label>
                    <input type="text" name="name" id="editName" class="form-input" placeholder="Nama menu" required>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Kategori *</label>
                        <select name="category" id="editCategory" class="form-input" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($categoryLabels as $val => $label)
                                <option value="{{ $val }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Harga (Rp) *</label>
                        <input type="number" name="price" id="editPrice" class="form-input" placeholder="0" required min="0">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" id="editDescription" class="form-input form-textarea" placeholder="Deskripsi menu (opsional)"></textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">Stok</label>
                    <div class="form-stock-row">
                        <input type="number" name="stock" id="editStock" class="form-input" placeholder="Jumlah stok" min="0">
                    </div>
                    <label class="form-checkbox" style="margin-top: 8px;">
                        <input type="checkbox" id="editUnlimitedStock" onchange="toggleEditStock()">
                        <span>Stok tidak terbatas</span>
                    </label>
                </div>
                <div class="form-group">
                    <label class="form-label">Gambar Baru (opsional)</label>
                    <input type="file" name="image" class="form-input" accept="image/*" style="padding: 8px;">
                </div>
                <label class="form-checkbox">
                    <input type="checkbox" name="is_available" id="editAvailable" value="1">
                    <span>Menu tersedia untuk dijual</span>
                </label>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-delete" onclick="deleteMenu()">🗑️ Hapus</button>
                <button type="button" class="btn-cancel" onclick="closeEditModal()">Batal</button>
                <button type="submit" class="btn-submit" style="background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);">💾 Update</button>
            </div>
        </form>
    </div>
</div>

<script>
// State
let cart = [];
let selectedItem = null;
let selectedQty = 1;

// Format
function formatRp(n) { return new Intl.NumberFormat('id-ID').format(n); }

// Receipt file handler
document.getElementById('receiptInput').addEventListener('change', function(e) {
    const label = document.getElementById('receiptLabel');
    if (e.target.files.length > 0) {
        label.textContent = '✓ ' + e.target.files[0].name;
        label.style.color = '#22c55e';
    } else {
        label.textContent = 'Upload Bukti/Struk';
        label.style.color = '#64748b';
    }
});

// Dropdown
function toggleDropdown() {
    const list = document.getElementById('menuDropdownList');
    const trigger = document.getElementById('menuDropdownTrigger');
    list.classList.toggle('open');
    trigger.classList.toggle('open');
}

function filterMenu() {
    const search = document.getElementById('menuSearch').value.toLowerCase();
    document.querySelectorAll('.menu-dropdown-item').forEach(item => {
        const name = (item.dataset.name || '').toLowerCase();
        item.style.display = name.includes(search) ? 'flex' : 'none';
    });
}

function selectMenu(el) {
    if (!el || !el.dataset) return;
    
    const name = el.dataset.name || 'Menu';
    const price = parseInt(el.dataset.price) || 0;
    const category = el.dataset.category || '';
    const image = el.dataset.image || '';
    const id = el.dataset.id || '';
    
    selectedItem = { id, name, price, category, image };
    selectedQty = 1;
    
    // Update trigger text
    document.getElementById('menuDropdownTrigger').querySelector('span').textContent = name;
    
    // Show preview
    document.getElementById('selectedMenu').classList.add('show');
    document.getElementById('selectedName').textContent = name;
    document.getElementById('selectedCategory').textContent = category;
    document.getElementById('selectedPrice').textContent = 'Rp ' + formatRp(price);
    document.getElementById('selectedQty').textContent = '1';
    
    if (image) {
        document.getElementById('selectedImg').src = image;
        document.getElementById('selectedImg').style.display = 'block';
    } else {
        document.getElementById('selectedImg').style.display = 'none';
    }
    
    // Close dropdown
    document.getElementById('menuDropdownList').classList.remove('open');
    document.getElementById('menuDropdownTrigger').classList.remove('open');
}

function changeQty(delta) {
    selectedQty = Math.max(1, selectedQty + delta);
    document.getElementById('selectedQty').textContent = selectedQty;
}

function addSelectedToCart() {
    if (!selectedItem) return;
    
    const existing = cart.find(i => i.id === selectedItem.id);
    if (existing) {
        existing.qty += selectedQty;
    } else {
        cart.push({ ...selectedItem, qty: selectedQty });
    }
    renderCart();
    
    // Reset selection
    document.getElementById('selectedMenu').classList.remove('show');
    document.getElementById('menuDropdownTrigger').querySelector('span').textContent = 'Pilih Menu...';
    selectedItem = null;
}

function editSelectedMenu() {
    if (!selectedItem) return;
    openEditModal(selectedItem.id);
}

// Close dropdown when clicking outside
document.addEventListener('click', (e) => {
    const container = document.querySelector('.menu-dropdown-container');
    if (!container.contains(e.target)) {
        document.getElementById('menuDropdownList').classList.remove('open');
        document.getElementById('menuDropdownTrigger').classList.remove('open');
    }
});

// Cart
function renderCart() {
    const container = document.getElementById('cartItems');
    
    if (cart.length === 0) {
        container.innerHTML = '<div class="cart-empty"><p>Keranjang kosong</p><p style="font-size: 13px;">Pilih menu untuk menambahkan</p></div>';
        document.getElementById('cartCount').textContent = '0 item';
        document.getElementById('cartTotal').textContent = 'Rp 0';
        return;
    }
    
    let html = '';
    let total = 0;
    
    cart.forEach((item, i) => {
        const subtotal = item.price * item.qty;
        total += subtotal;
        const itemName = item.name || 'Menu';
        html += `
        <div class="cart-item">
            <div class="cart-item-row">
                <span class="cart-item-name">${itemName}</span>
                <button type="button" class="cart-item-remove" onclick="removeItem(${i})">✕</button>
            </div>
            <div class="cart-item-details">
                <div class="cart-item-qty">
                    <button type="button" onclick="updateQty(${i}, -1)">−</button>
                    <span>${item.qty}</span>
                    <button type="button" onclick="updateQty(${i}, 1)">+</button>
                </div>
                <span class="cart-item-total">Rp ${formatRp(subtotal)}</span>
            </div>
        </div>`;
    });
    
    container.innerHTML = html;
    document.getElementById('cartCount').textContent = cart.length + ' item';
    document.getElementById('cartTotal').textContent = 'Rp ' + formatRp(total);
}

function updateQty(i, delta) {
    cart[i].qty += delta;
    if (cart[i].qty <= 0) cart.splice(i, 1);
    renderCart();
}

function removeItem(i) {
    cart.splice(i, 1);
    renderCart();
}

function clearCart() {
    if (cart.length === 0) return;
    if (confirm('Hapus semua item?')) {
        cart = [];
        renderCart();
    }
}

// Checkout
async function checkout() {
    if (cart.length === 0) return alert('Keranjang kosong!');
    
    const form = document.getElementById('checkoutForm');
    const formData = new FormData(form);
    
    if (!formData.get('payment_method')) return alert('Pilih metode pembayaran!');
    
    formData.append('items', JSON.stringify(cart.map(i => ({ menu_item_id: i.id, quantity: i.qty }))));
    
    const btn = document.getElementById('checkoutBtn');
    btn.disabled = true;
    btn.textContent = 'Memproses...';
    
    try {
        const res = await fetch('{{ route("sales.store") }}', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
            body: formData
        });
        const data = await res.json();
        
        if (data.success) {
            alert('✅ Transaksi berhasil!\nTotal: Rp ' + formatRp(data.total_amount));
            cart = [];
            renderCart();
            form.reset();
            form.querySelector('[name="transaction_date"]').value = '{{ date("Y-m-d") }}';
        } else {
            alert('❌ ' + data.message);
        }
    } catch (err) {
        alert('❌ Error: ' + err.message);
    } finally {
        btn.disabled = false;
        btn.innerHTML = '<svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Proses';
    }
}

// Add Menu Modal
function openAddModal() {
    document.getElementById('addMenuForm').reset();
    document.getElementById('addUnlimitedStock').checked = true;
    toggleAddStock();
    document.getElementById('addModal').classList.add('active');
}

function closeAddModal() {
    document.getElementById('addModal').classList.remove('active');
    document.getElementById('addMenuForm').reset();
}

// Toggle stok untuk Add Modal
function toggleAddStock() {
    const checkbox = document.getElementById('addUnlimitedStock');
    const stockInput = document.getElementById('addStock');
    if (checkbox.checked) {
        stockInput.value = '';
        stockInput.disabled = true;
        stockInput.placeholder = 'Tidak terbatas';
    } else {
        stockInput.disabled = false;
        stockInput.placeholder = 'Jumlah stok';
        stockInput.focus();
    }
}

// Toggle stok untuk Edit Modal
function toggleEditStock() {
    const checkbox = document.getElementById('editUnlimitedStock');
    const stockInput = document.getElementById('editStock');
    if (checkbox.checked) {
        stockInput.value = '';
        stockInput.disabled = true;
        stockInput.placeholder = 'Tidak terbatas';
    } else {
        stockInput.disabled = false;
        stockInput.placeholder = 'Jumlah stok';
        stockInput.focus();
    }
}

// Initialize Add Modal stok toggle
document.addEventListener('DOMContentLoaded', function() {
    toggleAddStock();
});

document.getElementById('addMenuForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const formData = new FormData(e.target);
    formData.append('_token', '{{ csrf_token() }}');
    
    // Handle checkbox is_available
    if (!e.target.querySelector('[name="is_available"]').checked) {
        formData.set('is_available', '0');
    }
    
    // Handle stok tidak terbatas
    const unlimitedStockChecked = document.getElementById('addUnlimitedStock').checked;
    if (unlimitedStockChecked) {
        formData.set('stock', '-1');
    }
    
    try {
        const res = await fetch('{{ route("menu.store") }}', {
            method: 'POST',
            headers: { 'Accept': 'application/json' },
            body: formData
        });
        
        const data = await res.json();
        
        if (data.success) {
            alert('✅ Menu berhasil ditambahkan!');
            location.reload();
        } else {
            alert('❌ ' + (data.message || 'Gagal menyimpan'));
        }
    } catch (err) {
        alert('❌ ' + err.message);
    }
});

// Edit Menu Modal
async function openEditModal(id) {
    try {
        const res = await fetch('/menu/' + id, {
            headers: { 'Accept': 'application/json' }
        });
        
        if (!res.ok) {
            throw new Error('Menu tidak ditemukan');
        }
        
        const menu = await res.json();
        
        // Safe value assignment dengan fallback
        document.getElementById('editId').value = menu.id || '';
        document.getElementById('editName').value = menu.name || '';
        document.getElementById('editCategory').value = menu.category || '';
        document.getElementById('editPrice').value = menu.price || 0;
        document.getElementById('editDescription').value = menu.description || '';
        document.getElementById('editAvailable').checked = menu.is_available == 1;
        
        // Handle stok - jika -1 berarti tidak terbatas
        const stockInput = document.getElementById('editStock');
        const unlimitedCheckbox = document.getElementById('editUnlimitedStock');
        
        if (menu.stock === -1 || menu.stock === null || menu.stock === undefined) {
            unlimitedCheckbox.checked = true;
            stockInput.value = '';
            stockInput.disabled = true;
            stockInput.placeholder = 'Tidak terbatas';
        } else {
            unlimitedCheckbox.checked = false;
            stockInput.value = menu.stock;
            stockInput.disabled = false;
            stockInput.placeholder = 'Jumlah stok';
        }
        
        document.getElementById('editModal').classList.add('active');
    } catch (err) {
        console.error('Error loading menu:', err);
        alert('❌ Gagal memuat data menu: ' + err.message);
    }
}

function closeEditModal() {
    document.getElementById('editModal').classList.remove('active');
}

document.getElementById('editMenuForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const id = document.getElementById('editId').value;
    const formData = new FormData(e.target);
    formData.append('_token', '{{ csrf_token() }}');
    formData.append('_method', 'PUT');
    
    // Handle checkbox is_available
    if (!e.target.querySelector('[name="is_available"]').checked) {
        formData.set('is_available', '0');
    }
    
    // Handle stok tidak terbatas
    const unlimitedStockChecked = document.getElementById('editUnlimitedStock').checked;
    if (unlimitedStockChecked) {
        formData.set('stock', '-1');
    }
    
    try {
        const res = await fetch('/menu/' + id, {
            method: 'POST',
            headers: { 'Accept': 'application/json' },
            body: formData
        });
        
        const data = await res.json();
        
        if (data.success) {
            alert('✅ Menu berhasil diupdate!');
            location.reload();
        } else {
            alert('❌ ' + (data.message || 'Gagal update'));
        }
    } catch (err) {
        alert('❌ ' + err.message);
    }
});

async function deleteMenu() {
    if (!confirm('Yakin hapus menu ini?')) return;
    
    const id = document.getElementById('editId').value;
    
    try {
        const res = await fetch('/menu/' + id, {
            method: 'DELETE',
            headers: { 
                'X-CSRF-TOKEN': '{{ csrf_token() }}', 
                'Accept': 'application/json' 
            }
        });
        
        const data = await res.json();
        
        if (data.success) {
            alert('✅ Menu dihapus!');
            location.reload();
        } else {
            alert('❌ ' + (data.message || 'Gagal hapus'));
        }
    } catch (err) {
        alert('❌ ' + err.message);
    }
}

// Close modal on overlay click
document.querySelectorAll('.modal-overlay').forEach(overlay => {
    overlay.addEventListener('click', (e) => {
        if (e.target === overlay) {
            overlay.classList.remove('active');
        }
    });
});
</script>
@endsection
