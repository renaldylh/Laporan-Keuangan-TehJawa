<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Header -->
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-teh-jawa-black mb-2">Buat Akun Baru</h2>
            <p class="text-teh-jawa-gray">Bergabung dengan Teh Jawa hari ini</p>
        </div>

        <!-- Name -->
        <div>
            <label for="name" class="label-teh-luxury">
                <svg class="icon-teh-small inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                Nama Lengkap
            </label>
            <input 
                id="name" 
                class="input-teh-luxury w-full" 
                type="text" 
                name="name" 
                :value="old('name')" 
                required 
                autofocus 
                autocomplete="name" 
                placeholder="Masukkan nama lengkap"
            />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="label-teh-luxury">
                <svg class="icon-teh-small inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                Email Address
            </label>
            <input 
                id="email" 
                class="input-teh-luxury w-full" 
                type="email" 
                name="email" 
                :value="old('email')" 
                required 
                autocomplete="username" 
                placeholder="nama@email.com"
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="label-teh-luxury">
                <svg class="icon-teh-small inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
                Password
            </label>
            <div class="relative">
                <input 
                    id="password" 
                    class="input-teh-luxury w-full pr-12" 
                    type="password" 
                    name="password"
                    required 
                    autocomplete="new-password" 
                    placeholder="Masukkan password"
                />
                <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center" onclick="togglePassword('password')">
                    <svg id="password-toggle" class="icon-teh-small" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="label-teh-luxury">
                <svg class="icon-teh-small inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Konfirmasi Password
            </label>
            <div class="relative">
                <input 
                    id="password_confirmation" 
                    class="input-teh-luxury w-full pr-12" 
                    type="password" 
                    name="password_confirmation" 
                    required 
                    autocomplete="new-password" 
                    placeholder="Konfirmasi password"
                />
                <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center" onclick="togglePassword('password_confirmation')">
                    <svg id="password_confirmation-toggle" class="icon-teh-small" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Terms and Conditions -->
        <div class="flex items-start">
            <input 
                id="terms" 
                type="checkbox" 
                class="rounded border-teh-jawa-gold/30 text-teh-jawa-gold shadow-sm focus:ring-teh-jawa-gold/20 focus:ring-2 bg-teh-jawa-cream/50 mt-1" 
                name="terms"
                required
            >
            <label for="terms" class="ml-2 text-sm text-teh-jawa-gray">
                Saya setuju dengan <a href="#" class="text-teh-jawa-gold hover:text-teh-jawa-gold-dark font-medium">Syarat dan Ketentuan</a> serta <a href="#" class="text-teh-jawa-gold hover:text-teh-jawa-gold-dark font-medium">Kebijakan Privasi</a>
            </label>
        </div>

        <!-- Submit Button -->
        <div class="mt-8">
            <button type="submit" class="btn-teh-primary w-full text-center">
                <svg class="icon-teh inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                </svg>
                {{ __('Daftar Sekarang') }}
            </button>
        </div>

        <!-- Login Link -->
        <div class="text-center mt-6">
            <p class="text-teh-jawa-gray">
                {{ __('Sudah punya akun?') }}
                <a href="{{ route('login') }}" class="text-teh-jawa-gold hover:text-teh-jawa-gold-dark font-semibold transition-colors duration-200">
                    {{ __('Masuk di sini') }}
                </a>
            </p>
        </div>
    </form>

    <script>
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const toggle = document.getElementById(inputId + '-toggle');
            
            if (input.type === 'password') {
                input.type = 'text';
                toggle.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>';
            } else {
                input.type = 'password';
                toggle.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>';
            }
        }
    </script>
</x-guest-layout>
