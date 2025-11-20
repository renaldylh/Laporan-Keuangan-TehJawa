<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        
        <div>
            <label for="current_password" class="label-teh">{{ __('Current Password') }}</label>
            <input type="password" name="current_password" id="current_password" 
                   class="input-teh w-full" 
                   required autocomplete="current-password">
            <x-input-error :messages="$errors->get('current_password')" class="mt-2" />
        </div>

        <div>
            <label for="password" class="label-teh">{{ __('New Password') }}</label>
            <input type="password" name="password" id="password" 
                   class="input-teh w-full" 
                   required autocomplete="new-password">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <label for="password_confirmation" class="label-teh">{{ __('Confirm Password') }}</label>
            <input type="password" name="password_confirmation" id="password_confirmation" 
                   class="input-teh w-full" 
                   required autocomplete="new-password">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between">
            <button type="submit" class="btn-teh-primary">
                <svg class="icon-teh-small mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                {{ __('Save') }}
            </button>

            <x-action-message class="text-sm text-green-600" on="password-updated">
                <span class="flex items-center">
                    <svg class="icon-teh-tiny mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    {{ __('Saved.') }}
                </span>
            </x-action-message>
        </div>
    </form>
</section>
