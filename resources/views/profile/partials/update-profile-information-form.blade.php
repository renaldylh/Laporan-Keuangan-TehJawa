<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form id="updateProfileInformation" method="POST" action="{{ route('profile.update') }}" class="space-y-6 mt-6">
        @csrf
        @method('PATCH')
        
        <div>
            <label for="name" class="label-teh">{{ __('Name') }}</label>
            <input type="text" name="name" id="name" 
                   class="input-teh w-full" 
                   :value="old('name', $user->name)" 
                   required autofocus autocomplete="name">
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <label for="email" class="label-teh">{{ __('Email') }}</label>
            <input type="email" name="email" id="email" 
                   class="input-teh w-full" 
                   :value="old('email', $user->email)" 
                   required autocomplete="username">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />

            @if ($user->email_verified_at)
                <div class="mt-3 p-3 bg-green-50 border border-green-200 rounded-lg">
                    <p class="text-sm text-green-600 flex items-center">
                        <svg class="icon-teh-tiny mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Email Anda telah terverifikasi
                    </p>
                </div>
            @else
                <div class="mt-3 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <p class="text-sm text-yellow-600">
                        Email Anda belum terverifikasi.
                    </p>
                    <button type="submit" name="action" value="send-verification" 
                            class="btn-teh-secondary mt-2 text-sm">
                        Kirim ulang email verifikasi
                    </button>
                </div>
            @endif
        </div>

        <div class="flex items-center justify-between">
            <button type="submit" class="btn-teh-primary">
                <svg class="icon-teh-small mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                {{ __('Save') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
