<section>
    <header class="mb-4">
        <h2 class="h5 mb-1">{{ __('Profile Information') }}</h2>
        <p class="small mb-0" style="color: var(--text-muted);">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        <div class="mb-3">
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div class="mb-3">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="small mb-0" style="color: var(--text-muted);">
                        {{ __('Your email address is unverified.') }}
                        <button form="send-verification" class="btn btn-link btn-sm p-0 align-baseline" style="color: var(--color-accent);">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="small mt-2 mb-0" style="color: var(--color-sage);">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="d-flex align-items-center gap-3 mt-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <span class="small" style="color: var(--color-sage);">{{ __('Saved.') }}</span>
            @endif
        </div>
    </form>
</section>
