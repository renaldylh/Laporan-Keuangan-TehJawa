@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-teh-jawa-cream via-white to-teh-jawa-gold-accent/20">
    <div class="container mx-auto px-4 py-6 md:py-8 max-w-2xl">
        
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('transactions.index') }}" class="text-teh-jawa-gold hover:text-teh-jawa-gold-dark font-semibold text-sm flex items-center gap-2 mb-4">
                <svg class="icon-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Transaksi
            </a>
            <h1 class="text-4xl font-bold text-teh-jawa-black mb-2">Catat Transaksi</h1>
            <p class="text-teh-jawa-gray">Record pemasukan lain dan pengeluaran bisnis Anda</p>
        </div>

        <!-- Form Card -->
        <div class="card-teh-luxury p-8 border-l-4 border-teh-jawa-gold">
            <form action="{{ route('transactions.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                
                <!-- Step 1: Jenis Transaksi -->
                <div>
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-8 h-8 rounded-full bg-teh-jawa-gold text-white flex items-center justify-center font-bold text-sm">1</div>
                        <label class="text-lg font-bold text-teh-jawa-black">Pilih Jenis Transaksi</label>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <label class="relative">
                            <input type="radio" name="type" value="income_other" class="peer sr-only" {{ old('type') == 'income_other' ? 'checked' : '' }}>
                            <div class="p-5 rounded-lg border-2 border-gray-200 cursor-pointer transition-all duration-200 peer-checked:border-teh-jawa-green peer-checked:bg-teh-jawa-green/5 peer-checked:shadow-lg hover:border-teh-jawa-green/50">
                                <div class="flex items-center gap-3">
                                    <div class="bg-teh-jawa-green/20 p-3 rounded-lg">
                                        <svg class="icon-lg text-teh-jawa-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-bold text-teh-jawa-green text-base">Pemasukan Lain</p>
                                        <p class="text-xs text-teh-jawa-gray">Catering, delivery, deposit, dll</p>
                                    </div>
                                </div>
                            </div>
                        </label>
                        
                        <label class="relative">
                            <input type="radio" name="type" value="expense" class="peer sr-only" {{ old('type') == 'expense' ? 'checked' : '' }}>
                            <div class="p-5 rounded-lg border-2 border-gray-200 cursor-pointer transition-all duration-200 peer-checked:border-red-500 peer-checked:bg-red-50 peer-checked:shadow-lg hover:border-red-300">
                                <div class="flex items-center gap-3">
                                    <div class="bg-red-100 p-3 rounded-lg">
                                        <svg class="icon-lg text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-bold text-red-600 text-base">Pengeluaran</p>
                                        <p class="text-xs text-teh-jawa-gray">Operasional, gaji, sewa, dll</p>
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>
                    @error('type')
                        <p class="text-red-500 text-sm mt-3 flex items-center gap-2">
                            <svg class="icon-sm" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="border-t border-teh-jawa-gold/10"></div>
                
                <!-- Step 2: Basic Information -->
                <div>
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-8 h-8 rounded-full bg-teh-jawa-gold text-white flex items-center justify-center font-bold text-sm">2</div>
                        <label class="text-lg font-bold text-teh-jawa-black">Informasi Transaksi</label>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="transaction_date" class="label-teh">Tanggal</label>
                            <div class="relative">
                                <input type="date" name="transaction_date" id="transaction_date" 
                                       class="input-teh w-full"
                                       value="{{ old('transaction_date', now()->format('Y-m-d')) }}"
                                       required>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="icon-sm text-teh-jawa-gray" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </div>
                            @error('transaction_date')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="amount" class="label-teh">Jumlah</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-teh-jawa-gray font-semibold">Rp</span>
                                <input type="number" step="0.01" name="amount" id="amount" 
                                       class="input-teh w-full pl-10"
                                       value="{{ old('amount') }}"
                                       placeholder="0"
                                       min="0"
                                       required>
                            </div>
                            @error('amount')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="border-t border-teh-jawa-gold/10"></div>
                
                <!-- Step 3: Description & Payment -->
                <div>
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-8 h-8 rounded-full bg-teh-jawa-gold text-white flex items-center justify-center font-bold text-sm">3</div>
                        <label class="text-lg font-bold text-teh-jawa-black">Detail Pembayaran</label>
                    </div>
                    
                    <div class="mb-6">
                        <label for="description" class="label-teh">Deskripsi / Keterangan</label>
                        <textarea name="description" id="description" rows="3" 
                                  class="input-teh w-full resize-none"
                                  placeholder="Jelaskan detail transaksi... (contoh: Catering event, Gaji karyawan, Pembelian bahan baku, dll)"
                                  maxlength="255"
                                  required>{{ old('description') }}</textarea>
                        <div class="flex justify-between mt-1.5">
                            <span class="text-xs text-teh-jawa-gray">Jelaskan tujuan transaksi</span>
                            <span class="text-xs text-teh-jawa-gray">{{ strlen(old('description')) }}/255</span>
                        </div>
                        @error('description')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="payment_method" class="label-teh">Metode Pembayaran</label>
                        <div class="relative">
                            <select name="payment_method" id="payment_method" 
                                    class="input-teh w-full appearance-none"
                                    required>
                                <option value="">Pilih metode pembayaran</option>
                                <option value="Tunai" {{ old('payment_method') == 'Tunai' ? 'selected' : '' }}>💵 Tunai</option>
                                <option value="Transfer Bank" {{ old('payment_method') == 'Transfer Bank' ? 'selected' : '' }}>🏦 Transfer Bank</option>
                                <option value="Kartu Debit" {{ old('payment_method') == 'Kartu Debit' ? 'selected' : '' }}>🏧 Kartu Debit</option>
                                <option value="E-Wallet" {{ old('payment_method') == 'E-Wallet' ? 'selected' : '' }}>📱 E-Wallet</option>
                                <option value="Kredit" {{ old('payment_method') == 'Kredit' ? 'selected' : '' }}>💳 Kredit</option>
                                <option value="Lainnya" {{ old('payment_method') == 'Lainnya' ? 'selected' : '' }}>➕ Lainnya</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg class="icon-sm text-teh-jawa-gray" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                        @error('payment_method')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="receipt" class="label-teh">Upload Bukti (Nota/Kwitansi) <span class="text-xs font-normal text-teh-jawa-gray">(Opsional)</span></label>
                        <input type="file" name="receipt" id="receipt" 
                               class="input-teh w-full"
                               accept="image/*,.pdf">
                        <p class="text-xs text-teh-jawa-gray mt-1">Format: JPG, PNG, atau PDF (Max: 2MB)</p>
                        @error('receipt')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="border-t border-teh-jawa-gold/10"></div>
                
                <!-- Step 4: Details (Optional) -->
                <div>
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-8 h-8 rounded-full bg-teh-jawa-gold text-white flex items-center justify-center font-bold text-sm">4</div>
                        <label class="text-lg font-bold text-teh-jawa-black">Rincian Transaksi <span class="text-sm font-normal text-teh-jawa-gray">(Opsional)</span></label>
                    </div>
                    
                    <!-- Income Details Section -->
                    <div id="incomeDetailsSection" class="hidden">
                        <div id="incomeItemsContainer" class="space-y-4">
                            <div class="income-item-row border border-gray-200 rounded-lg p-4">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="md:col-span-2">
                                        <label class="label-teh text-sm">Kategori Pemasukan</label>
                                        <select name="details[0][menu_name]" class="input-teh w-full income-category-select">
                                            <option value="">Pilih kategori</option>
                                            @foreach($incomeCategories as $category)
                                                <option value="{{ $category }}">{{ $category }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="label-teh text-sm">Jumlah</label>
                                        <div class="relative">
                                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-teh-jawa-gray font-semibold text-sm">Rp</span>
                                            <input type="number" name="details[0][total_price]" class="input-teh w-full pl-10 income-amount-input" 
                                                   value="0" min="0">
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="details[0][quantity]" value="1">
                                <input type="hidden" name="details[0][unit_price]" value="0">
                                <div class="mt-3">
                                    <input type="text" name="details[0][notes]" class="input-teh w-full" 
                                           placeholder="Catatan (opsional)">
                                </div>
                            </div>
                        </div>
                        
                        <button type="button" id="addIncomeItemBtn" class="mt-4 text-teh-jawa-green hover:text-teh-jawa-green-dark font-semibold text-sm flex items-center gap-2">
                            <svg class="icon-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Tambah Item Pemasukan
                        </button>
                    </div>
                    
                    <!-- Expense Details Section -->
                    <div id="expenseDetailsSection" class="hidden">
                        <div id="expenseItemsContainer" class="space-y-4">
                            <div class="expense-item-row border border-gray-200 rounded-lg p-4">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="md:col-span-2">
                                        <label class="label-teh text-sm">Kategori Pengeluaran</label>
                                        <select name="details[0][menu_name]" class="input-teh w-full expense-category-select">
                                            <option value="">Pilih kategori</option>
                                            @foreach($expenseCategories as $category)
                                                <option value="{{ $category }}">{{ $category }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="label-teh text-sm">Jumlah</label>
                                        <div class="relative">
                                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-teh-jawa-gray font-semibold text-sm">Rp</span>
                                            <input type="number" name="details[0][total_price]" class="input-teh w-full pl-10 expense-amount-input" 
                                                   value="0" min="0">
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="details[0][quantity]" value="1">
                                <input type="hidden" name="details[0][unit_price]" value="0">
                                <div class="mt-3">
                                    <input type="text" name="details[0][notes]" class="input-teh w-full" 
                                           placeholder="Catatan (opsional)">
                                </div>
                            </div>
                        </div>
                        
                        <button type="button" id="addExpenseItemBtn" class="mt-4 text-red-500 hover:text-red-700 font-semibold text-sm flex items-center gap-2">
                            <svg class="icon-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Tambah Item Pengeluaran
                        </button>
                    </div>
                </div>

                <div class="border-t border-teh-jawa-gold/10 pt-6"></div>
                
                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 md:gap-4">
                    <a href="{{ route('transactions.index') }}" class="btn-teh-secondary btn-teh-lg flex items-center justify-center">
                        <svg class="icon-md" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        <span>Batal</span>
                    </a>
                    <button type="submit" class="btn-teh-primary btn-teh-lg flex-1 flex items-center justify-center">
                        <svg class="icon-md" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Simpan Transaksi</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let incomeItemCount = 1;
    let expenseItemCount = 1;
    
    // Show/hide detail sections based on transaction type
    const typeRadios = document.querySelectorAll('input[name="type"]');
    const incomeDetailsSection = document.getElementById('incomeDetailsSection');
    const expenseDetailsSection = document.getElementById('expenseDetailsSection');
    
    function toggleDetailSections() {
        const selectedType = document.querySelector('input[name="type"]:checked')?.value;
        
        if (selectedType === 'income_other') {
            incomeDetailsSection.classList.remove('hidden');
            expenseDetailsSection.classList.add('hidden');
        } else if (selectedType === 'expense') {
            incomeDetailsSection.classList.add('hidden');
            expenseDetailsSection.classList.remove('hidden');
        } else {
            incomeDetailsSection.classList.add('hidden');
            expenseDetailsSection.classList.add('hidden');
        }
    }
    
    typeRadios.forEach(radio => {
        radio.addEventListener('change', toggleDetailSections);
    });
    
    // Initialize
    toggleDetailSections();
    
    // Income item handlers
    document.getElementById('addIncomeItemBtn').addEventListener('click', function() {
        const container = document.getElementById('incomeItemsContainer');
        const newRow = createIncomeItemRow(incomeItemCount);
        container.insertAdjacentHTML('beforeend', newRow);
        incomeItemCount++;
    });
    
    // Expense item handlers
    document.getElementById('addExpenseItemBtn').addEventListener('click', function() {
        const container = document.getElementById('expenseItemsContainer');
        const newRow = createExpenseItemRow(expenseItemCount);
        container.insertAdjacentHTML('beforeend', newRow);
        expenseItemCount++;
    });
    
    // Event delegation for dynamic elements
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('income-amount-input') || e.target.classList.contains('expense-amount-input')) {
            updateMainAmount();
        }
    });
    
    function updateMainAmount() {
        let totalAmount = 0;
        
        // Sum all income amounts
        document.querySelectorAll('.income-amount-input').forEach(input => {
            totalAmount += parseFloat(input.value) || 0;
        });
        
        // Sum all expense amounts
        document.querySelectorAll('.expense-amount-input').forEach(input => {
            totalAmount += parseFloat(input.value) || 0;
        });
        
        const mainAmountInput = document.getElementById('amount');
        if (mainAmountInput.value === '' || mainAmountInput.value === '0') {
            mainAmountInput.value = totalAmount;
        }
    }
    
    function createIncomeItemRow(index) {
        const incomeCategories = @json($incomeCategories);
        let options = '<option value="">Pilih kategori</option>';
        incomeCategories.forEach(category => {
            options += `<option value="${category}">${category}</option>`;
        });
        
        return `
            <div class="income-item-row border border-gray-200 rounded-lg p-4">
                <div class="flex justify-between items-center mb-3">
                    <h4 class="font-semibold text-teh-jawa-black">Item #${index + 1}</h4>
                    <button type="button" class="text-red-500 hover:text-red-700 remove-item-btn">
                        <svg class="icon-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="md:col-span-2">
                        <label class="label-teh text-sm">Kategori Pemasukan</label>
                        <select name="details[${index}][menu_name]" class="input-teh w-full income-category-select">
                            ${options}
                        </select>
                    </div>
                    <div>
                        <label class="label-teh text-sm">Jumlah</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-teh-jawa-gray font-semibold text-sm">Rp</span>
                            <input type="number" name="details[${index}][total_price]" class="input-teh w-full pl-10 income-amount-input" 
                                   value="0" min="0">
                        </div>
                    </div>
                </div>
                <input type="hidden" name="details[${index}][quantity]" value="1">
                <input type="hidden" name="details[${index}][unit_price]" value="0">
                <div class="mt-3">
                    <input type="text" name="details[${index}][notes]" class="input-teh w-full" 
                           placeholder="Catatan (opsional)">
                </div>
            </div>
        `;
    }
    
    function createExpenseItemRow(index) {
        const expenseCategories = @json($expenseCategories);
        let options = '<option value="">Pilih kategori</option>';
        expenseCategories.forEach(category => {
            options += `<option value="${category}">${category}</option>`;
        });
        
        return `
            <div class="expense-item-row border border-gray-200 rounded-lg p-4">
                <div class="flex justify-between items-center mb-3">
                    <h4 class="font-semibold text-teh-jawa-black">Item #${index + 1}</h4>
                    <button type="button" class="text-red-500 hover:text-red-700 remove-item-btn">
                        <svg class="icon-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="md:col-span-2">
                        <label class="label-teh text-sm">Kategori Pengeluaran</label>
                        <select name="details[${index}][menu_name]" class="input-teh w-full expense-category-select">
                            ${options}
                        </select>
                    </div>
                    <div>
                        <label class="label-teh text-sm">Jumlah</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-teh-jawa-gray font-semibold text-sm">Rp</span>
                            <input type="number" name="details[${index}][total_price]" class="input-teh w-full pl-10 expense-amount-input" 
                                   value="0" min="0">
                        </div>
                    </div>
                </div>
                <input type="hidden" name="details[${index}][quantity]" value="1">
                <input type="hidden" name="details[${index}][unit_price]" value="0">
                <div class="mt-3">
                    <input type="text" name="details[${index}][notes]" class="input-teh w-full" 
                           placeholder="Catatan (opsional)">
                </div>
            </div>
        `;
    }
    
    // Remove item handler
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-item-btn')) {
            const row = e.target.closest('.income-item-row, .expense-item-row');
            row.remove();
            updateMainAmount();
        }
    });
});
</script>
@endpush
@endsection
