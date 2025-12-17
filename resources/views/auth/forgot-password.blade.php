<x-guest-layout>
    <div class="min-h-screen bg-gradient-to-br from-teh-jawa-cream via-white to-teh-jawa-gold-accent/20 flex items-center justify-center px-4">
        <div class="max-w-md w-full">
            <div class="card-teh-luxury p-8 border-l-4 border-teh-jawa-gold">
                <div class="text-center mb-6">
                    <svg class="icon-teh-large mx-auto text-teh-jawa-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                    </svg>
                    <h2 class="text-2xl md:text-3xl font-bold bg-gradient-to-r from-teh-jawa-gold to-teh-jawa-brown bg-clip-text text-transparent mt-4">
                        Reset Password
                    </h2>
                    <p class="text-teh-jawa-gray mt-2 text-sm md:text-base">
                        Lupa password? Tidak masalah. Masukkan email Anda dan kami akan mengirimkan link reset password.
                    </p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="label-teh flex items-center gap-2">
                            <svg class="icon-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <span>Email Address</span>
                        </label>
                        <input 
                            type="email" 
                            name="email" 
                            id="email" 
                            class="input-teh w-full" 
                            :value="old('email')" 
                            required 
                            autofocus
                            placeholder="nama@email.com"
                        >
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3">
                        <button type="submit" class="btn-teh-primary flex-1 flex items-center justify-center">
                            <svg class="icon-sm mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            Kirim Link Reset
                        </button>
                        
                        <a href="{{ route('login') }}" class="btn-teh-secondary flex items-center justify-center">
                            <svg class="icon-sm mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
