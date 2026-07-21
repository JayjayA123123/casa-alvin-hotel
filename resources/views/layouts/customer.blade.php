<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard') - {{ config('app.name', 'StayPinas') }}</title>

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
            --navy-soft: #2a3a5c;
            --orange: #f5941f;
            --orange-dark: #d9790a;
            --orange-soft: #fff2e0;
            --ink: #17233d;
            --text-muted: #6b7385;
            --text-faint: #97a0b0;
            --line: #e7e9ee;
            --bg: #f6f7fa;
            --panel: #ffffff;
            --success: #1c8a52;
            --danger: #d1483a;
            --info: #2f6fe0;
        }

        * { box-sizing: border-box; }
        html, body { height: 100%; }

        body {
            background: var(--bg);
            color: var(--ink);
            font-family: 'Inter', sans-serif;
        }

        h1, h2, h3, h4, .brand-font { font-family: 'Poppins', sans-serif; font-weight: 700; color: var(--navy); }
        a { color: var(--orange-dark); text-decoration: none; }
        a:hover { color: var(--orange); }
        .text-muted { color: var(--text-muted) !important; }

        .btn { border-radius: 9px; font-weight: 600; font-size: .92rem; transition: background-color .15s ease, border-color .15s ease, transform .1s ease; }
        .btn:active { transform: scale(.97); }
        .btn-primary, .btn-orange { background: var(--orange); border: 1px solid var(--orange-dark); color: #fff; }
        .btn-primary:hover, .btn-orange:hover { background: var(--orange-dark); border-color: var(--orange-dark); color: #fff; }
        .btn-navy { background: var(--navy); border: 1px solid var(--navy); color: #fff; }
        .btn-navy:hover { background: var(--navy-dark); border-color: var(--navy-dark); color: #fff; }
        .btn-outline-navy { border: 1px solid var(--line); color: var(--navy); background: #fff; }
        .btn-outline-navy:hover { background: var(--bg); color: var(--navy); }

        .card, .bg-white, .panel { background: var(--panel); border: 1px solid var(--line); border-radius: 14px; }
        .shadow-card { box-shadow: 0 8px 24px rgba(23, 35, 61, 0.06); }

        .badge { font-weight: 600; font-size: .74rem; padding: .4em .7em; border-radius: 6px; }
        .badge-pending { background: #fff2e0; color: var(--orange-dark); }
        .badge-confirmed { background: #e5edff; color: var(--info); }
        .badge-completed { background: #e3f6ec; color: var(--success); }
        .badge-cancelled { background: #fbe7e4; color: var(--danger); }

        .stat-card { padding: 1.2rem 1.3rem; transition: transform .15s ease, box-shadow .15s ease; }
        .stat-card:hover { transform: translateY(-4px); box-shadow: 0 16px 30px rgba(23, 35, 61, 0.12); }
        .stat-card .stat-value { font-size: 1.6rem; font-weight: 800; color: var(--navy); }
        .stat-card .stat-label { font-size: .8rem; color: var(--text-muted); }
        .stat-card.stat-orange .stat-value { color: var(--orange-dark); }

        /* ---------- Fade-in on load ---------- */
        @keyframes fadeSlideIn {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .admin-main .panel,
        .admin-main .stat-card {
            animation: fadeSlideIn .4s ease both;
        }

        .admin-main .row.g-3 > div:nth-child(1) .stat-card { animation-delay: .03s; }
        .admin-main .row.g-3 > div:nth-child(2) .stat-card { animation-delay: .09s; }
        .admin-main .row.g-3 > div:nth-child(3) .stat-card { animation-delay: .15s; }
        .admin-main .row.g-3 > div:nth-child(4) .stat-card { animation-delay: .21s; }

        .table { color: var(--ink); }
        .table thead th { font-size: .75rem; text-transform: uppercase; letter-spacing: .03em; color: var(--text-faint); border-bottom: 1px solid var(--line); font-weight: 700; }
        .table td { vertical-align: middle; border-bottom: 1px solid var(--line); font-size: .9rem; }

        /* ---------- Customer dashboard shell (same look as admin sidebar) ---------- */
        .admin-shell { display: flex; min-height: 100vh; }

        .admin-sidebar {
            width: 240px;
            flex-shrink: 0;
            background: var(--navy-dark);
            color: rgba(255, 255, 255, .82);
            padding: 1.4rem 1rem;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
        }

        .admin-sidebar .brand {
            display: flex; align-items: center; gap: .6rem;
            font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 1.05rem; color: #fff;
            padding: .3rem .6rem 1.3rem;
        }

        .admin-sidebar .brand-mark {
            width: 34px; height: 34px; border-radius: 9px; background: transparent;
            display: inline-flex; align-items: center; justify-content: center; font-size: 1rem; flex-shrink: 0; padding: 2px;
        }

        .admin-sidebar .nav-link {
            display: flex; align-items: center; gap: .65rem;
            color: rgba(255,255,255,.72); font-size: .89rem; font-weight: 500;
            padding: .6rem .7rem; border-radius: 9px; margin-bottom: .15rem;
            transition: background-color .15s ease, color .15s ease, padding-left .15s ease;
        }

        .admin-sidebar .nav-link i { font-size: 1rem; width: 1.1rem; text-align: center; transition: transform .15s ease; }
        .admin-sidebar .nav-link:hover { background: rgba(255,255,255,.06); color: #fff; padding-left: .95rem; }
        .admin-sidebar .nav-link:hover i { transform: translateX(2px); }
        .admin-sidebar .nav-link.active { background: var(--orange); color: #fff; }
        .admin-sidebar .nav-link.logout-link { color: rgba(255, 120, 100, .85); }
        .admin-sidebar .nav-link.logout-link:hover { background: rgba(209, 72, 58, .16); color: #ff9c8d; padding-left: .95rem; }

        .admin-main { flex: 1; min-width: 0; padding: 1.6rem 1.8rem 3rem; }

        .admin-topbar {
            display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: .8rem;
            margin-bottom: 1.4rem;
        }

        @media (max-width: 900px) {
            .admin-shell { flex-direction: column; }
            .admin-sidebar { width: 100%; height: auto; position: relative; padding: 1rem; }
            .admin-main { padding: 1.2rem; }
        }
    </style>

    @stack('styles')
</head>
<body>

    <div class="admin-shell">
        <aside class="admin-sidebar">
            <a href="{{ url('/') }}" class="brand">
                <span class="brand-mark"><img src="{{ asset('images/staypinas-mark.svg') }}" alt="StayPinas" style="width:100%;height:100%;object-fit:contain;"></span>
                StayPinas
            </a>

            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2-fill"></i> Dashboard
            </a>
            <a href="{{ route('bookings.index') }}" class="nav-link {{ request()->routeIs('bookings.index') ? 'active' : '' }}">
                <i class="bi bi-journal-check"></i> My Bookings
            </a>
            <a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                <i class="bi bi-person-fill"></i> Profile
            </a>
            <a href="{{ route('profile.edit') }}#password" class="nav-link">
                <i class="bi bi-gear-fill"></i> Settings
            </a>

            <hr style="border-color: rgba(255,255,255,.1); margin: .8rem .2rem;">

            <a href="{{ url('/') }}" class="nav-link">
                <i class="bi bi-box-arrow-up-right"></i> View Site
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-link logout-link border-0 bg-transparent w-100 text-start">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </aside>

        <main class="admin-main">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
