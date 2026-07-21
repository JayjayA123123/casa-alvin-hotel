<x-guest-layout
    hero-title="Confirm It's You"
    hero-description="This is a secure area. Please confirm your password before continuing."
    card-label="Security Check"
    card-title="Confirm Password"
>
    <p class="small mb-4" style="color: var(--text-muted);">
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </p>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <div class="mb-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <x-primary-button class="w-100 py-2">
            {{ __('Confirm') }}
        </x-primary-button>
    </form>
</x-guest-layout>
