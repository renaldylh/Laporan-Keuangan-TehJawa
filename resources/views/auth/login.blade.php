<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Header -->
        <div class="text-center mb-6">
            <h2 class="text-2xl md:text-3xl font-bold text-teh-jawa-black mb-2">Selamat Datang Kembali</h2>
            <p class="text-xs md:text-sm text-teh-jawa-gray">Masuk ke akun Teh Jawa Anda</p>
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="label-teh flex items-center gap-2">
                <svg class="icon-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                <span>Email Address</span>
            </label>
            <input 
                id="email" 
                class="input-teh" 
                type="email" 
                name="email" 
                :value="old('email')" 
                required 
                autofocus 
                autocomplete="username" 
                placeholder="nama@email.com"
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="label-teh flex items-center gap-2">
                <svg class="icon-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
                <span>Password</span>
            </label>
            <input 
                id="password" 
                class="input-teh" 
                type="password" 
                name="password"
                required 
                autocomplete="current-password" 
                placeholder="Masukkan password"
            />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input 
                id="remember_me" 
                type="checkbox" 
                class="rounded border-gray-300 text-teh-jawa-gold shadow-sm focus:ring-teh-jawa-green" 
                name="remember"
            />
            <label for="remember_me" class="ml-2 text-xs md:text-sm text-gray-600">
                Ingat Saya
            </label>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn-teh-primary btn-teh-lg w-full justify-center">
            <svg class="icon-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
            </svg>
            <span>Masuk</span>
        </button>

        <!-- Links -->
        <div class="flex flex-col sm:flex-row items-center justify-center gap-2 sm:gap-4 text-xs md:text-sm">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-teh-jawa-gold hover:text-teh-jawa-gold-dark font-medium transition-colors">
                    Lupa Password?
                </a>
            @endif
            
            <span class="hidden sm:block text-teh-jawa-gray">|</span>
            
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="text-teh-jawa-gold hover:text-teh-jawa-gold-dark font-medium transition-colors">
                    Daftar Akun
                </a>
            @endif
        </div>
    </form>
</x-guest-layout>
