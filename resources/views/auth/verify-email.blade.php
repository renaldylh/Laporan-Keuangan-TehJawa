<x-guest-layout>
    <div class="container mx-auto px-4 py-6">
        <div class="max-w-md mx-auto">
            <div class="card-teh">
                <div class="text-center mb-6">
                    <svg class="icon-teh-large mx-auto text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    <h2 class="text-2xl font-bold text-gray-800 mt-4">Verifikasi Email Anda</h2>
                    <p class="text-gray-600 mt-2">{{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}</p>
                </div>

                @if (session('status') == 'verification-link-sent')
                    <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                        <p class="text-sm text-green-600">{{ __('A new verification link has been sent to the email address you provided during registration.') }}</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <div class="space-y-4">
                        <button type="submit" class="btn-teh-primary w-full">
                            <svg class="icon-teh-small mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            {{ __('Resend Verification Email') }}
                        </button>

                        <form method="POST" action="{{ route('logout') }}" class="inline-block w-full">
                            @csrf
                            <button type="submit" class="btn-teh-secondary w-full">
                                <svg class="icon-teh-small mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                {{ __('Log Out') }}
                            </button>
                        </form>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
