<x-guest-layout
    hero-title="Forgot Password?"
    hero-description="Enter your email address and we'll send you a link to reset your password."
    card-label="Account Recovery"
    card-title="Forgot Password"
    hero-image="https://images.unsplash.com/photo-1611892440504-42a792e24d32?q=80&w=1200&auto=format&fit=crop"
>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="mb-4">
            <x-input-label for="email" value="Email Address" />
            <div class="field-icon">
                <i class="bi bi-envelope leading"></i>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="form-control" placeholder="juan@email.com">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <x-primary-button class="w-100 py-2">Send Reset Link</x-primary-button>

        <p class="text-center text-muted small mt-3 mb-0">
            <a href="{{ route('login') }}"><i class="bi bi-arrow-left me-1"></i>Back to Sign In</a>
        </p>
    </form>

    <div class="helper-box">
        <i class="bi bi-clipboard-check"></i>
        <div>
            <strong>Didn't receive the email?</strong>
            Check your spam folder or try again. <a href="{{ route('password.email') }}" onclick="event.preventDefault(); this.closest('.reservation-card').querySelector('form').requestSubmit();">Resend Email</a>
        </div>
    </div>
</x-guest-layout>
