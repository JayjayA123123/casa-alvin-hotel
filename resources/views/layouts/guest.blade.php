@props([
    'heroTitle' => null,
    'heroDescription' => null,
    'cardLabel' => 'StayPinas',
    'cardTitle' => 'Welcome',
    'heroImage' => 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?q=80&w=1200&auto=format&fit=crop',
])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $cardTitle }} - {{ config('app.name', 'StayPinas') }}</title>

    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700;800&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        :root {
            --navy: #17233d;
            --navy-dark: #101929;
            --orange: #f5941f;
            --orange-dark: #d9790a;
            --ink: #17233d;
            --text-muted: #6b7385;
            --text-faint: #97a0b0;
            --line: #e7e9ee;
            --bg: #f6f7fa;
            --panel: #ffffff;
            --success: #1c8a52;
            --danger: #d1483a;
        }

        * { box-sizing: border-box; }
        html, body { height: 100%; }

        body { background: #fff; color: var(--ink); font-family: 'Inter', sans-serif; min-height: 100vh; }
        h1, .brand-font { font-family: 'Poppins', sans-serif; font-weight: 700; }
        a { color: var(--orange-dark); text-decoration: none; }
        a:hover { color: var(--orange); }

        .auth-split { min-height: 100vh; display: flex; }

        .auth-split__hero {
            flex: 1 1 50%;
            background: url('{{ $heroImage }}') center/cover no-repeat;
            min-height: 100vh;
        }

        @media (max-width: 991.98px) { .auth-split__hero { display: none; } }

        .auth-split__form { flex: 1 1 50%; display: flex; align-items: center; justify-content: center; padding: 2.5rem 1.5rem; background: #fff; }

        .auth-card { width: 100%; max-width: 400px; }

        .auth-card__brand { display: flex; align-items: center; justify-content: center; gap: .5rem; margin-bottom: 1.5rem; font-weight: 700; font-size: 1.15rem; color: var(--navy); }
        .auth-card__brand .brand-mark { width: 34px; height: 34px; border-radius: 9px; background: transparent; display: inline-flex; align-items: center; justify-content: center; font-size: 1rem; padding: 2px; }

        .auth-card small.eyebrow { display: block; text-align: center; text-transform: uppercase; letter-spacing: .1em; font-size: .68rem; font-weight: 700; color: var(--orange-dark); margin-bottom: .4rem; }
        .auth-card h1.title { text-align: center; font-size: 1.6rem; font-weight: 700; color: var(--ink); margin-bottom: .3rem; }
        .auth-card p.subtitle { text-align: center; color: var(--text-muted); font-size: .9rem; margin-bottom: 1.6rem; }

        .reservation-card { background: var(--panel); }

        .field-icon { position: relative; }
        .field-icon .toggle-visibility { position: absolute; right: .85rem; top: 50%; transform: translateY(-50%); color: var(--text-faint); background: none; border: none; cursor: pointer; }
        .field-icon .toggle-visibility:hover { color: var(--orange-dark); }
        .field-icon:has(.toggle-visibility) .form-control { padding-right: 2.4rem; }

        .btn-primary {
            background: var(--navy);
            border: 1px solid var(--navy);
            color: #fff;
            font-weight: 700;
            border-radius: 9px;
            padding: .7rem 1.25rem;
        }
        .btn-primary:hover, .btn-primary:focus { background: var(--navy-dark); border-color: var(--navy-dark); color: #fff; }

        .form-label { color: var(--ink); font-size: .85rem; font-weight: 600; margin-bottom: .4rem; }
        .form-control { background: #fff; border: 1px solid var(--line); color: var(--ink); border-radius: 9px; padding: .65rem .9rem; font-size: .92rem; }
        .form-control::placeholder { color: var(--text-faint); }
        .form-control:focus { border-color: var(--orange); box-shadow: 0 0 0 .2rem rgba(245, 148, 31, 0.14); }

        .form-check-input:checked { background-color: var(--orange); border-color: var(--orange); }
        .form-check-input:focus { border-color: var(--orange); box-shadow: 0 0 0 .2rem rgba(245, 148, 31, 0.14); }
        .form-check-label { color: var(--text-muted); }
        .text-muted { color: var(--text-faint) !important; }

        .alert-success { background: rgba(28, 138, 82, 0.08); border: 1px solid rgba(28, 138, 82, 0.25); color: var(--success); border-radius: 10px; }
        .alert-danger, .text-danger { color: var(--danger) !important; }

        .strength-meter { display: flex; gap: 4px; margin: .5rem 0 .7rem; }
        .strength-meter span { flex: 1; height: 4px; border-radius: 2px; background: var(--line); }
        .strength-meter span.on-weak { background: var(--danger); }
        .strength-meter span.on-medium { background: var(--orange); }
        .strength-meter span.on-strong { background: var(--success); }
        .strength-label { font-size: .74rem; font-weight: 600; color: var(--text-faint); margin-bottom: .8rem; }
        .strength-label.weak { color: var(--danger); }
        .strength-label.medium { color: var(--orange-dark); }
        .strength-label.strong { color: var(--success); }

        .password-checklist { list-style: none; padding: 0; margin: 0 0 1rem; display: flex; flex-direction: column; gap: .35rem; }
        .password-checklist li { font-size: .78rem; color: var(--text-faint); display: flex; align-items: center; gap: .5rem; }
        .password-checklist li.met { color: var(--success); }
        .password-checklist li.met i { color: var(--success); }

        .helper-box {
            display: flex; gap: .7rem; align-items: flex-start; background: var(--bg); border: 1px solid var(--line);
            border-radius: 12px; padding: .9rem 1rem; margin-top: 1.4rem; font-size: .82rem; color: var(--text-muted);
        }
        .helper-box i { color: var(--orange-dark); font-size: 1rem; margin-top: .1rem; }
        .helper-box strong { color: var(--ink); display: block; margin-bottom: .1rem; }

        .auth-success-wrap { min-height: 100vh; display: flex; align-items: center; justify-content: center; background: #fff; }
        .auth-success-card { text-align: center; max-width: 420px; padding: 1rem 2rem; }
        .auth-success-icon { width: 76px; height: 76px; border-radius: 50%; background: var(--success); color: #fff; display: inline-flex; align-items: center; justify-content: center; font-size: 2rem; margin-bottom: 1.5rem; }
        .auth-success-card h1 { font-size: 1.7rem; font-weight: 700; margin-bottom: .6rem; }
        .auth-success-card p { color: var(--text-muted); margin-bottom: 1.6rem; }
    </style>

    @stack('styles')
</head>
<body>

    <div class="auth-split">
        <div class="auth-split__hero"></div>

        <div class="auth-split__form">
            <div class="auth-card">
                <div class="auth-card__brand">
                    <span class="brand-mark"><img src="{{ asset('images/staypinas-mark.svg') }}" alt="StayPinas" style="width:100%;height:100%;object-fit:contain;"></span>
                    StayPinas
                </div>

                <h1 class="title">{{ $cardTitle }}</h1>
                @if ($heroDescription)
                    <p class="subtitle">{{ $heroDescription }}</p>
                @endif

                <div class="reservation-card">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.toggle-visibility').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var input = btn.parentElement.querySelector('input');
                var icon = btn.querySelector('i');
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('bi-eye');
                    icon.classList.add('bi-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('bi-eye-slash');
                    icon.classList.add('bi-eye');
                }
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
