<x-guest-layout
    hero-title="Create New Password"
    hero-description="Please enter your new password below."
    card-label="Account Recovery"
    card-title="Reset Password"
    hero-image="https://images.unsplash.com/photo-1611892440504-42a792e24d32?q=80&w=1200&auto=format&fit=crop"
>
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="mb-3">
            <x-input-label for="email" value="Email Address" />
            <div class="field-icon">
                <i class="bi bi-envelope leading"></i>
                <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username" class="form-control" placeholder="juan@email.com">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mb-1">
            <x-input-label for="password" value="New Password" />
            <div class="field-icon">
                <i class="bi bi-lock leading"></i>
                <input id="password" type="password" name="password" required autocomplete="new-password" class="form-control" placeholder="At least 8 characters">
                <button type="button" class="toggle-visibility" tabindex="-1"><i class="bi bi-eye"></i></button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="strength-meter" id="strength-meter">
            <span></span><span></span><span></span><span></span>
        </div>
        <div class="strength-label" id="strength-label">&nbsp;</div>

        <ul class="password-checklist" id="password-checklist">
            <li data-rule="length"><i class="bi bi-circle"></i> At least 8 characters</li>
            <li data-rule="case"><i class="bi bi-circle"></i> Contains uppercase &amp; lowercase letters</li>
            <li data-rule="number"><i class="bi bi-circle"></i> Contains a number</li>
            <li data-rule="special"><i class="bi bi-circle"></i> Contains a special character</li>
        </ul>

        <div class="mb-4">
            <x-input-label for="password_confirmation" value="Confirm New Password" />
            <div class="field-icon">
                <i class="bi bi-lock leading"></i>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="form-control" placeholder="Type it again">
                <button type="button" class="toggle-visibility" tabindex="-1"><i class="bi bi-eye"></i></button>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <x-primary-button class="w-100 py-2">Reset Password</x-primary-button>

        <p class="text-center text-muted small mt-3 mb-0">
            <a href="{{ route('login') }}"><i class="bi bi-arrow-left me-1"></i>Back to Sign In</a>
        </p>
    </form>
</x-guest-layout>

@push('scripts')
<script>
    (function () {
        var pwd = document.getElementById('password');
        if (!pwd) return;

        var bars = document.querySelectorAll('#strength-meter span');
        var label = document.getElementById('strength-label');
        var items = document.querySelectorAll('#password-checklist li');

        pwd.addEventListener('input', function () {
            var v = pwd.value;
            var rules = {
                length: v.length >= 8,
                case: /[a-z]/.test(v) && /[A-Z]/.test(v),
                number: /[0-9]/.test(v),
                special: /[^A-Za-z0-9]/.test(v),
            };

            items.forEach(function (li) {
                var met = rules[li.dataset.rule];
                li.classList.toggle('met', met);
                var icon = li.querySelector('i');
                icon.className = met ? 'bi bi-check-circle-fill' : 'bi bi-circle';
            });

            var score = Object.values(rules).filter(Boolean).length;

            bars.forEach(function (bar, i) {
                bar.className = '';
                if (score >= 1 && i === 0) bar.classList.add(score <= 2 ? 'on-weak' : (score === 3 ? 'on-medium' : 'on-strong'));
                if (score >= 2 && i === 1) bar.classList.add(score <= 2 ? 'on-weak' : (score === 3 ? 'on-medium' : 'on-strong'));
                if (score >= 3 && i === 2) bar.classList.add(score === 3 ? 'on-medium' : 'on-strong');
                if (score >= 4 && i === 3) bar.classList.add('on-strong');
            });

            label.textContent = v.length === 0 ? '' : (score <= 2 ? 'Weak' : (score === 3 ? 'Medium' : 'Strong'));
            label.className = 'strength-label ' + (score <= 2 ? 'weak' : (score === 3 ? 'medium' : 'strong'));
        });
    })();
</script>
@endpush
