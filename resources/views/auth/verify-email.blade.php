<x-guest-layout
    hero-title="Verify Your Email"
    hero-description="One last step before you can start booking your stay."
    card-label="Almost There"
    card-title="Verify Email"
    hero-image="https://images.unsplash.com/photo-1618773928121-c32242e63f39?q=80&w=1200&auto=format&fit=crop"
>
    <div class="text-center mb-3">
        <span class="auth-success-icon" style="width:64px;height:64px;background:rgba(232,182,74,.14);color:var(--gold);font-size:1.5rem;">
            <i class="bi bi-envelope"></i>
        </span>
        <h2 class="h5 mb-2" style="color:var(--ink);">Verify Your Email</h2>
        <p class="small mb-1" style="color:var(--text-muted);">
            We've sent a verification link to
        </p>
        <p class="small fw-semibold mb-3" style="color: var(--gold);">{{ auth()->user()->email }}</p>
        <p class="small mb-0" style="color:var(--text-muted);">
            Please check your email and click the link to verify your account.
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="alert-success py-2 px-3 small mb-3 text-center">
            A new verification link has been sent to your email address.
        </div>
    @endif

    <a href="https://mail.google.com" target="_blank" class="btn btn-primary w-100 py-2 d-block text-center mb-3">Go to Email</a>

    <div class="d-flex align-items-center justify-content-between">
        <form method="POST" action="{{ route('verification.send') }}" class="mb-0">
            @csrf
            <button type="submit" class="btn btn-sm p-0" style="color: var(--text-muted); background: transparent; border: none;">
                Didn't receive the email? <span style="color: var(--gold); font-weight:600;">Resend Email</span>
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}" class="mb-0">
            @csrf
            <button type="submit" class="btn btn-sm p-0" style="color: var(--text-faint); background: transparent; border: none;">
                Log Out
            </button>
        </form>
    </div>
</x-guest-layout>
