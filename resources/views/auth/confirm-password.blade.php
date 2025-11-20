<x-guest-layout>
    <div class="container mx-auto px-4 py-6">
        <div class="max-w-md mx-auto">
            <div class="card-teh">
                <div class="text-center mb-6">
                    <svg class="icon-teh-large mx-auto text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    <h2 class="text-2xl font-bold text-gray-800 mt-4">Konfirmasi Password</h2>
                    <p class="text-gray-600 mt-2">{{ __('This is a secure area of the application. Please confirm your password before continuing.') }}</p>
                </div>

                <form method="POST" action="{{ route('password.confirm') }}">
                    @csrf

                    <!-- Password -->
                    <div>
                        <label for="password" class="label-teh">{{ __('Password') }}</label>
                        <input type="password" name="password" id="password" 
                               class="input-teh w-full" 
                               required autocomplete="current-password">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="btn-teh-primary w-full">
                            <svg class="icon-teh-small mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                            {{ __('Confirm') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
