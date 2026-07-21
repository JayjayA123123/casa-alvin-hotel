<x-guest-layout
    card-title="Create an Account"
    hero-description="Fill in the details to get started"
    hero-image="https://images.unsplash.com/photo-1618773928121-c32242e63f39?q=80&w=1200&auto=format&fit=crop"
>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-3">
            <x-input-label for="name" value="Full Name" />
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" class="form-control" placeholder="Enter your full name">
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mb-3">
            <x-input-label for="email" value="Email Address" />
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" class="form-control" placeholder="Enter your email">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mb-3">
            <x-input-label for="password" value="Password" />
            <div class="field-icon">
                <input id="password" type="password" name="password" required autocomplete="new-password" class="form-control" placeholder="Enter your password">
                <button type="button" class="toggle-visibility" tabindex="-1"><i class="bi bi-eye"></i></button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mb-3">
            <x-input-label for="password_confirmation" value="Confirm Password" />
            <div class="field-icon">
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="form-control" placeholder="Confirm your password">
                <button type="button" class="toggle-visibility" tabindex="-1"><i class="bi bi-eye"></i></button>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="form-check mb-4">
            <input class="form-check-input" type="checkbox" name="terms" id="terms" required>
            <label class="form-check-label small" for="terms">
                I agree to the <a href="#">Terms and Conditions</a>
            </label>
        </div>

        <x-primary-button class="w-100 py-2">Register</x-primary-button>

        <p class="text-center text-muted small mt-4 mb-0">
            Already have an account?
            <a href="{{ route('login') }}" style="font-weight: 600;">Login</a>
        </p>
    </form>
</x-guest-layout>
