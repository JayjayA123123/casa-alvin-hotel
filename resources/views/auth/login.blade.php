<x-guest-layout
    card-title="Welcome Back!"
    hero-description="Login to continue"
    hero-image="https://images.unsplash.com/photo-1611892440504-42a792e24d32?q=80&w=1200&auto=format&fit=crop"
>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <x-input-label for="email" value="Email Address" />
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="form-control" placeholder="Enter your email">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mb-3">
            <x-input-label for="password" value="Password" />
            <div class="field-icon">
                <input id="password" type="password" name="password" required autocomplete="current-password" class="form-control" placeholder="Enter your password">
                <button type="button" class="toggle-visibility" tabindex="-1"><i class="bi bi-eye"></i></button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
                <label class="form-check-label small" for="remember_me">Remember me</label>
            </div>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="small">Forgot Password?</a>
            @endif
        </div>

        <x-primary-button class="w-100 py-2">Login</x-primary-button>

        <p class="text-center text-muted small mt-4 mb-0">
            Don't have an account?
            <a href="{{ route('register') }}" style="font-weight: 600;">Register</a>
        </p>
    </form>
</x-guest-layout>
