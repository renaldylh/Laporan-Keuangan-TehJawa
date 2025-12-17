<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Teh Jawa - Sistem Manajemen Keuangan Premium untuk Usaha Anda">

        <title>Teh Jawa - Manajemen Keuangan Premium</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <!-- Background decoration -->
        <div class="fixed inset-0 -z-10 overflow-hidden">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-gradient-to-br from-teh-jawa-gold/20 to-teh-jawa-gold-accent/30 rounded-full blur-3xl animate-teh-float"></div>
            <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-gradient-to-tr from-teh-jawa-gold/15 to-teh-jawa-cream/40 rounded-full blur-3xl animate-teh-float" style="animation-delay: 1s;"></div>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-gradient-to-r from-teh-jawa-gold/10 to-transparent rounded-full blur-2xl"></div>
        </div>

        <!-- Navigation -->
        <header class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-teh-jawa-gold/10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-14 sm:h-16">
                    <!-- Logo -->
                    <div class="flex items-center">
                        <a href="/" class="flex items-center">
                            <div class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-br from-teh-jawa-gold to-teh-jawa-gold-dark rounded-xl sm:rounded-2xl shadow-lg flex items-center justify-center mr-2 sm:mr-3">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M2.5 2.5C2.5 2.5 6.5 7.5 12 7.5C17.5 7.5 21.5 2.5 21.5 2.5M21.5 2.5C21.5 2.5 17.5 7.5 12 7.5C6.5 7.5 2.5 2.5 2.5 2.5M2.5 2.5V21.5H21.5V2.5M12 12C12 13.3807 11.3807 14.5 10.5 14.5C9.61929 14.5 9 13.3807 9 12C9 10.6193 9.61929 9.5 10.5 9.5C11.3807 9.5 12 10.6193 12 12ZM15 14.5C15.8807 14.5 16.5 13.3807 16.5 12C16.5 10.6193 15.8807 9.5 15 9.5C14.1193 9.5 13.5 10.6193 13.5 12C13.5 13.3807 14.1193 14.5 15 14.5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                                </svg>
                            </div>
                            <span class="text-lg sm:text-xl font-bold bg-gradient-to-r from-teh-jawa-gold to-teh-jawa-brown bg-clip-text text-transparent">Teh Jawa</span>
                        </a>
                    </div>

                    <!-- Navigation Links -->
                    @if (Route::has('login'))
                        <nav class="flex items-center space-x-2 sm:space-x-4">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="btn-teh-ghost text-sm">Dashboard</a>
                                <form method="POST" action="{{ route('logout') }}" class="inline">
                                    @csrf
                                    <button type="submit" class="btn-teh-ghost text-sm">Keluar</button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="btn-teh-ghost text-sm">Masuk</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="btn-teh-primary text-sm">Daftar</a>
                                @endif
                            @endauth
                        </nav>
                    @endif
                </div>
            </div>
        </header>

        <!-- Hero Section -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12 lg:py-16">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-center">
                <!-- Left Content -->
                <div class="space-y-6">
                    <div>
                        <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-teh-jawa-black mb-3 leading-tight">
                            Kelola Keuangan Usaha Anda dengan
                            <span class="bg-gradient-to-r from-teh-jawa-gold to-teh-jawa-brown bg-clip-text text-transparent">Mudah & Elegan</span>
                        </h1>
                        <p class="text-sm sm:text-base lg:text-lg text-teh-jawa-gray mb-6">
                            Teh Jawa adalah solusi manajemen keuangan premium yang dirancang khusus untuk usaha Anda. Pantau transaksi, kelola laporan, dan buat keputusan bisnis yang lebih baik.
                        </p>
                    </div>

                    <!-- Features -->
                    <div class="space-y-3">
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0 w-5 h-5 rounded-full bg-teh-jawa-gold/20 flex items-center justify-center mt-0.5">
                                <svg class="w-3 h-3 text-teh-jawa-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <p class="text-sm text-teh-jawa-gray"><strong>Pencatatan Transaksi Real-time</strong> — Catat setiap transaksi dengan mudah.</p>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0 w-5 h-5 rounded-full bg-teh-jawa-gold/20 flex items-center justify-center mt-0.5">
                                <svg class="w-3 h-3 text-teh-jawa-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <p class="text-sm text-teh-jawa-gray"><strong>Laporan Keuangan Komprehensif</strong> — Buat laporan detail untuk periode apapun.</p>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0 w-5 h-5 rounded-full bg-teh-jawa-gold/20 flex items-center justify-center mt-0.5">
                                <svg class="w-3 h-3 text-teh-jawa-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <p class="text-sm text-teh-jawa-gray"><strong>Dashboard Intuitif</strong> — Visualisasi data keuangan yang modern.</p>
                        </div>
                    </div>

                    <!-- CTA Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3 pt-2">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn-teh-primary text-center">Buka Dashboard</a>
                        @else
                            <a href="{{ route('register') }}" class="btn-teh-primary text-center">Mulai Sekarang</a>
                            <a href="{{ route('login') }}" class="btn-teh-outline text-center">Sudah Punya Akun?</a>
                        @endauth
                    </div>
                </div>

                <!-- Right Illustration (hidden on mobile) -->
                <div class="hidden lg:flex items-center justify-center">
                    <div class="relative w-full max-w-md">
                        <div class="absolute inset-0 bg-gradient-to-br from-teh-jawa-gold/10 to-teh-jawa-brown/10 rounded-3xl transform rotate-3"></div>
                        <div class="relative bg-white rounded-3xl shadow-2xl border border-teh-jawa-gold/20 p-6">
                            <div class="space-y-4">
                                <div>
                                    <p class="text-xs text-teh-jawa-gray mb-1">Pemasukan Bulanan</p>
                                    <p class="text-2xl font-bold text-teh-jawa-green">Rp 25.500.000</p>
                                </div>
                                <div class="border-t border-gray-200 pt-3">
                                    <p class="text-xs text-teh-jawa-gray mb-2">Transaksi Terbaru</p>
                                    <div class="space-y-2 text-sm">
                                        <div class="flex justify-between items-center">
                                            <span class="text-gray-700">Penjualan Produk</span>
                                            <span class="font-semibold text-teh-jawa-green">+ Rp 5.000.000</span>
                                        </div>
                                        <div class="flex justify-between items-center">
                                            <span class="text-gray-700">Biaya Operasional</span>
                                            <span class="font-semibold text-red-600">- Rp 1.500.000</span>
                                        </div>
                                    </div>
                                </div>
                                <button class="w-full bg-gradient-to-r from-teh-jawa-gold to-teh-jawa-brown text-white font-semibold py-2 rounded-lg hover:shadow-lg transition-all text-sm">
                                    Lihat Laporan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Section -->
            <div class="grid grid-cols-3 gap-4 sm:gap-8 mt-12 pt-8 border-t border-teh-jawa-gold/20">
                <div class="text-center">
                    <p class="text-2xl sm:text-3xl md:text-4xl font-bold text-teh-jawa-gold mb-1">100+</p>
                    <p class="text-xs sm:text-sm text-teh-jawa-gray">Pengguna Aktif</p>
                </div>
                <div class="text-center">
                    <p class="text-2xl sm:text-3xl md:text-4xl font-bold text-teh-jawa-gold mb-1">1M+</p>
                    <p class="text-xs sm:text-sm text-teh-jawa-gray">Transaksi Tercatat</p>
                </div>
                <div class="text-center">
                    <p class="text-2xl sm:text-3xl md:text-4xl font-bold text-teh-jawa-gold mb-1">99.9%</p>
                    <p class="text-xs sm:text-sm text-teh-jawa-gray">Keandalan</p>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="border-t border-teh-jawa-gold/10 py-6 mt-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-6 text-sm">
                    <div class="col-span-2 md:col-span-1">
                        <div class="flex items-center mb-3">
                            <div class="w-7 h-7 bg-gradient-to-br from-teh-jawa-gold to-teh-jawa-gold-dark rounded-lg flex items-center justify-center mr-2">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M2.5 2.5C2.5 2.5 6.5 7.5 12 7.5C17.5 7.5 21.5 2.5 21.5 2.5M21.5 2.5C21.5 2.5 17.5 7.5 12 7.5C6.5 7.5 2.5 2.5 2.5 2.5M2.5 2.5V21.5H21.5V2.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                                </svg>
                            </div>
                            <span class="font-bold text-teh-jawa-black">Teh Jawa</span>
                        </div>
                        <p class="text-xs text-teh-jawa-gray">Sistem manajemen keuangan premium untuk usaha Anda.</p>
                    </div>
                    <div>
                        <h3 class="font-semibold text-teh-jawa-black mb-2">Produk</h3>
                        <ul class="space-y-1 text-xs text-teh-jawa-gray">
                            <li><a href="#" class="hover:text-teh-jawa-gold transition">Dashboard</a></li>
                            <li><a href="#" class="hover:text-teh-jawa-gold transition">Laporan</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="font-semibold text-teh-jawa-black mb-2">Perusahaan</h3>
                        <ul class="space-y-1 text-xs text-teh-jawa-gray">
                            <li><a href="#" class="hover:text-teh-jawa-gold transition">Tentang Kami</a></li>
                            <li><a href="#" class="hover:text-teh-jawa-gold transition">Kontak</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="font-semibold text-teh-jawa-black mb-2">Legal</h3>
                        <ul class="space-y-1 text-xs text-teh-jawa-gray">
                            <li><a href="#" class="hover:text-teh-jawa-gold transition">Privasi</a></li>
                            <li><a href="#" class="hover:text-teh-jawa-gold transition">Syarat & Ketentuan</a></li>
                        </ul>
                    </div>
                </div>
                <div class="border-t border-teh-jawa-gold/20 pt-4 text-center text-xs text-teh-jawa-gray">
                    <p>&copy; 2024 Teh Jawa. Semua hak dilindungi.</p>
                </div>
            </div>
        </footer>
    </body>
</html>
