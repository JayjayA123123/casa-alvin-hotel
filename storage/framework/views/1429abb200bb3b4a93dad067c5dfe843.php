<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo $__env->yieldContent('title', 'StayPinas'); ?> - <?php echo e(config('app.name', 'StayPinas')); ?></title>

    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/icon-192.png">

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

        body {
            background: var(--bg);
            color: var(--ink);
            font-family: 'Inter', sans-serif;
        }

        h1, h2, h3, h4, .brand-font { font-family: 'Poppins', sans-serif; font-weight: 700; color: var(--navy); }
        a { color: var(--orange-dark); text-decoration: none; }
        a:hover { color: var(--orange); }
        .text-muted { color: var(--text-muted) !important; }

        /* ---------- Navbar ---------- */
        .hotel-navbar {
            background: var(--navy);
            padding-top: .85rem;
            padding-bottom: .85rem;
            position: relative;
            z-index: 1050;
        }

        .hotel-navbar .navbar-brand {
            display: flex;
            align-items: center;
            gap: .55rem;
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 1.15rem;
            color: #fff !important;
        }

        .hotel-navbar .brand-mark {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: transparent;
            font-size: 1.05rem;
            flex-shrink: 0;
            padding: 2px;
        }

        .brand-mark {
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .hotel-navbar .nav-link {
            color: rgba(255, 255, 255, 0.78) !important;
            font-weight: 500;
            font-size: .93rem;
        }

        .hotel-navbar .nav-link:hover, .hotel-navbar .nav-link.active { color: #fff !important; }

        .hotel-navbar .navbar-text { color: rgba(255, 255, 255, 0.78) !important; }
        .hotel-navbar .navbar-text:hover { color: #fff !important; }

        .btn-hotel-outline {
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: #fff;
            background: transparent;
            border-radius: 8px;
            font-weight: 600;
            font-size: .88rem;
        }

        .btn-hotel-outline:hover { border-color: #fff; background: rgba(255, 255, 255, 0.08); color: #fff; }

        /* ---------- Buttons ---------- */
        .btn { border-radius: 9px; font-weight: 600; font-size: .92rem; }

        .btn-primary, .btn-orange {
            background: var(--orange);
            border: 1px solid var(--orange-dark);
            color: #fff;
        }

        .btn-primary:hover, .btn-primary:focus, .btn-orange:hover {
            background: var(--orange-dark);
            border-color: var(--orange-dark);
            color: #fff;
        }

        .btn-navy {
            background: var(--navy);
            border: 1px solid var(--navy);
            color: #fff;
        }

        .btn-navy:hover { background: var(--navy-dark); border-color: var(--navy-dark); color: #fff; }

        .btn-outline-navy {
            border: 1px solid var(--line);
            color: var(--navy);
            background: #fff;
        }

        .btn-outline-navy:hover { background: var(--bg); color: var(--navy); }

        /* ---------- Cards / panels ---------- */
        .card, .bg-white, .panel {
            background: var(--panel);
            border: 1px solid var(--line);
            border-radius: 14px;
        }

        .shadow-card { box-shadow: 0 8px 24px rgba(23, 35, 61, 0.06); }

        /* ---------- Hero / search bar (landing page) ---------- */
        .hotel-hero {
            position: relative;
            background:
                linear-gradient(180deg, rgba(16, 25, 41, 0.55), rgba(16, 25, 41, 0.75)),
                url('https://images.unsplash.com/photo-1571003123894-1f0594d2b5d9?q=80&w=1600&auto=format&fit=crop') center/cover no-repeat;
            padding: 4.5rem 0 6rem;
            color: #fff;
            margin-bottom: -3.5rem;
        }

        .hotel-hero h1 { color: #fff; font-size: 2.4rem; margin-bottom: .8rem; }
        .hotel-hero p.lead { color: rgba(255, 255, 255, 0.85); max-width: 34rem; }

        .search-bar {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 20px 45px rgba(16, 25, 41, 0.25);
            padding: 1.1rem 1.3rem;
        }

        .search-bar label {
            font-size: .7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .04em;
            color: var(--text-faint);
            margin-bottom: .2rem;
            display: block;
        }

        .search-bar .form-control, .search-bar .form-select {
            border: none;
            padding-left: 0;
            font-weight: 600;
            color: var(--ink);
        }

        .search-bar .form-control:focus, .search-bar .form-select:focus { box-shadow: none; }

        /* ---------- Room cards ---------- */
        .room-card { overflow: hidden; transition: transform .15s ease, box-shadow .15s ease; height: 100%; }
        .room-card:hover { transform: translateY(-4px); box-shadow: 0 16px 30px rgba(23, 35, 61, 0.12); }
        .room-card__img { height: 170px; width: 100%; object-fit: cover; }
        .room-card__body { padding: 1.1rem 1.2rem 1.3rem; }
        .room-card__title { font-size: 1.05rem; margin-bottom: .15rem; }
        .room-card__meta { font-size: .82rem; color: var(--text-muted); display: flex; align-items: center; gap: .3rem; margin-bottom: .6rem; }
        .room-card__facts { display: flex; gap: .9rem; font-size: .8rem; color: var(--text-muted); margin-bottom: .8rem; flex-wrap: wrap; }
        .room-card__facts span { display: flex; align-items: center; gap: .3rem; }
        .room-card__price { font-weight: 800; color: var(--navy); font-size: 1.05rem; }
        .room-card__price small { font-weight: 500; color: var(--text-faint); font-size: .75rem; }

        /* ---------- Feature icon grid ---------- */
        .feature-icon-item { text-align: center; }
        .feature-icon-item .icon-wrap {
            width: 56px; height: 56px; border-radius: 14px; background: var(--orange-soft); color: var(--orange-dark);
            display: inline-flex; align-items: center; justify-content: center; font-size: 1.4rem; margin-bottom: .8rem;
        }
        .feature-icon-item h4 { font-size: 1rem; margin-bottom: .3rem; }
        .feature-icon-item p { font-size: .85rem; color: var(--text-muted); margin: 0; }

        /* ---------- Testimonials ---------- */
        .testimonial-card { padding: 1.4rem 1.5rem; }
        .testimonial-card .stars { color: var(--orange); font-size: .85rem; margin-bottom: .6rem; }
        .testimonial-card p.quote { font-size: .9rem; color: var(--ink); margin-bottom: .8rem; }
        .testimonial-card .author { font-size: .82rem; font-weight: 700; color: var(--text-muted); }

        /* ---------- Badges / status ---------- */
        .badge { font-weight: 600; font-size: .74rem; padding: .4em .7em; border-radius: 6px; }
        .badge-upcoming, .badge-pending { background: #e5edff; color: var(--info); }
        .badge-confirmed { background: #e5edff; color: var(--info); }
        .badge-completed { background: #e3f6ec; color: var(--success); }
        .badge-cancelled { background: #fbe7e4; color: var(--danger); }

        /* ---------- Stat cards ---------- */
        .stat-card { padding: 1.2rem 1.3rem; }
        .stat-card .stat-value { font-size: 1.6rem; font-weight: 800; color: var(--navy); }
        .stat-card .stat-label { font-size: .8rem; color: var(--text-muted); }
        .stat-card.stat-orange .stat-value { color: var(--orange-dark); }

        /* ---------- Filter sidebar ---------- */
        .filter-block { padding: 1.2rem 1.3rem; margin-bottom: 1rem; }
        .filter-block h6 { font-size: .82rem; font-weight: 700; text-transform: uppercase; letter-spacing: .03em; color: var(--text-muted); margin-bottom: .8rem; }
        .filter-block .form-check { margin-bottom: .45rem; font-size: .88rem; }
        .filter-block .form-check-input:checked { background-color: var(--orange); border-color: var(--orange); }

        /* ---------- Tables ---------- */
        .table { color: var(--ink); }
        .table thead th { font-size: .75rem; text-transform: uppercase; letter-spacing: .03em; color: var(--text-faint); border-bottom: 1px solid var(--line); font-weight: 700; }
        .table td { vertical-align: middle; border-bottom: 1px solid var(--line); font-size: .9rem; }

        /* ---------- Nav tabs (My Bookings) ---------- */
        .nav-tabs { border-bottom: 1px solid var(--line); }
        .nav-tabs .nav-link { border: none; color: var(--text-muted); font-weight: 600; font-size: .9rem; padding: .6rem 1rem; }
        .nav-tabs .nav-link.active { color: var(--navy); border-bottom: 2px solid var(--orange); background: transparent; }

        /* ---------- Forms (general, non-auth) ---------- */
        .form-label { font-weight: 600; font-size: .85rem; color: var(--ink); }
        .form-control, .form-select {
            border: 1px solid var(--line);
            border-radius: 9px;
            padding: .6rem .8rem;
            font-size: .9rem;
        }
        .form-control:focus, .form-select:focus { border-color: var(--orange); box-shadow: 0 0 0 .2rem rgba(245, 148, 31, 0.14); }

        /* ---------- Legacy component compatibility (rooms/show, create, edit, bookings/show, edit) ---------- */
        .reservation-card { background: var(--panel); border: 1px solid var(--line); border-radius: 14px; overflow: hidden; }
        .reservation-card__stub { display: flex; justify-content: space-between; align-items: center; padding: 1.4rem 1.6rem; background: var(--navy); color: #fff; }
        .reservation-card__stub small { text-transform: uppercase; letter-spacing: .08em; font-size: .7rem; color: rgba(255,255,255,.65); }
        .reservation-card__stub h1 { color: #fff; font-size: 1.3rem; margin: .1rem 0 0; }
        .reservation-card__perforation { display: none; }
        .reservation-card__body { padding: 1.6rem; }

        .booking-section { margin-bottom: 1.6rem; }
        .booking-section__title { font-weight: 700; font-size: .95rem; color: var(--navy); margin-bottom: .9rem; display: flex; align-items: center; gap: .5rem; }
        .booking-section__step {
            width: 24px; height: 24px; border-radius: 50%; background: var(--orange); color: #fff; font-size: .78rem;
            display: inline-flex; align-items: center; justify-content: center; font-weight: 700;
        }

        .stay-summary { background: var(--panel); border: 1px solid var(--line); border-radius: 14px; overflow: hidden; box-shadow: 0 8px 24px rgba(23, 35, 61, 0.06); }
        .stay-summary__image {
            height: 180px; background-size: cover; background-position: center; background-color: var(--bg);
            display: flex; align-items: center; justify-content: center; color: var(--text-faint); font-size: .85rem; position: relative;
        }
        .stay-summary__badge {
            position: absolute; top: 12px; right: 12px; background: var(--success); color: #fff; font-size: .72rem;
            font-weight: 700; padding: .3em .8em; border-radius: 999px;
        }
        .stay-summary__body { padding: 1.4rem 1.5rem; }
        .stay-summary__eyebrow { text-transform: uppercase; font-size: .7rem; font-weight: 700; letter-spacing: .05em; color: var(--orange-dark); }
        .stay-summary__title { font-size: 1.2rem; font-weight: 700; color: var(--navy); margin-bottom: .1rem; }
        .stay-summary__subtitle { font-size: .85rem; color: var(--text-muted); margin-bottom: 1rem; }
        .stay-summary__row { display: flex; justify-content: space-between; font-size: .9rem; color: var(--text-muted); padding: .35rem 0; }
        .stay-summary__row .value { color: var(--ink); font-weight: 600; }
        .stay-summary__divider { border-top: 1px solid var(--line); margin: .8rem 0; }
        .stay-summary__total { display: flex; justify-content: space-between; font-size: 1.2rem; font-weight: 800; color: var(--navy); padding-top: .6rem; }
        .stay-summary__note { display: flex; gap: .5rem; align-items: flex-start; font-size: .8rem; color: var(--text-muted); margin-top: 1rem; background: var(--bg); border-radius: 10px; padding: .8rem .9rem; }
        .stay-summary__note i { color: var(--orange-dark); }

        .badge.bg-secondary { background: var(--bg) !important; color: var(--text-muted) !important; border: 1px solid var(--line); font-weight: 600; }

        /* ---------- Footer ---------- */
        .site-footer { background: var(--navy-dark); color: rgba(255,255,255,.7); padding: 3rem 0 1.5rem; margin-top: 4rem; }
        .site-footer h6 { color: #fff; font-size: .85rem; font-weight: 700; text-transform: uppercase; letter-spacing: .03em; margin-bottom: 1rem; }
        .site-footer a { color: rgba(255,255,255,.65); font-size: .88rem; }
        .site-footer a:hover { color: var(--orange); }
        .site-footer .footer-bottom { border-top: 1px solid rgba(255,255,255,.1); margin-top: 2rem; padding-top: 1.2rem; font-size: .82rem; color: rgba(255,255,255,.5); }
        .site-footer .social-icon {
            width: 34px; height: 34px; border-radius: 50%; background: rgba(255,255,255,.08); display: inline-flex;
            align-items: center; justify-content: center; color: #fff; margin-right: .5rem;
        }
        .site-footer .social-icon:hover { background: var(--orange); color: #fff; }

        @media (max-width: 767.98px) {
            .hotel-hero { padding: 3rem 0 5rem; }
            .hotel-hero h1 { font-size: 1.7rem; }
        }

        /* ---------- Animations ---------- */
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-16px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(24px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes floatY {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-6px); }
        }

        @media (prefers-reduced-motion: no-preference) {
            .hotel-navbar { animation: fadeInDown .6s ease both; }

            .hotel-hero h1, .hotel-hero p.lead, .search-bar {
                animation: fadeInUp .7s ease both;
            }
            .hotel-hero p.lead { animation-delay: .1s; }
            .search-bar { animation-delay: .2s; }

            /* Scroll-reveal utility: add class="reveal" (optionally reveal-1..reveal-6 for stagger) */
            .reveal {
                opacity: 0;
                transform: translateY(28px);
                transition: opacity .6s ease, transform .6s ease;
            }
            .reveal.in-view { opacity: 1; transform: translateY(0); }

            .reveal-1.in-view { transition-delay: .05s; }
            .reveal-2.in-view { transition-delay: .12s; }
            .reveal-3.in-view { transition-delay: .19s; }
            .reveal-4.in-view { transition-delay: .26s; }
            .reveal-5.in-view { transition-delay: .33s; }
            .reveal-6.in-view { transition-delay: .4s; }
        }

        /* Hover polish */
        .btn { transition: transform .15s ease, box-shadow .15s ease, background-color .15s ease, border-color .15s ease; }
        .btn:hover { transform: translateY(-2px); }
        .btn-orange:hover { box-shadow: 0 10px 20px rgba(245, 148, 31, 0.28); }
        .btn-navy:hover { box-shadow: 0 10px 20px rgba(23, 35, 61, 0.28); }

        .feature-icon-item .icon-wrap { transition: transform .25s ease, background-color .25s ease; }
        .feature-icon-item:hover .icon-wrap { transform: translateY(-3px) scale(1.06); background: var(--orange); color: #fff; }

        .testimonial-card, .stay-summary, .stat-card { transition: transform .15s ease, box-shadow .15s ease; }
        .testimonial-card:hover { transform: translateY(-3px); box-shadow: 0 16px 30px rgba(23, 35, 61, 0.1); }

        .social-icon { transition: transform .2s ease, background-color .2s ease; }
        .social-icon:hover { transform: translateY(-3px); }
    </style>

    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>

    <nav class="navbar navbar-expand-lg hotel-navbar mb-4">
        <div class="container">
            <a class="navbar-brand" href="<?php echo e(url('/')); ?>">
                <span class="brand-mark"><img src="<?php echo e(asset('images/staypinas-mark.svg')); ?>" alt="StayPinas" style="width:100%;height:100%;object-fit:contain;"></span>
                StayPinas
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain" style="border-color: rgba(255,255,255,.3);">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navMain">
                <ul class="navbar-nav mx-lg-auto">
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(url('/')); ?>">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(route('rooms.index')); ?>">Rooms</a></li>
                    <?php if(auth()->guard()->check()): ?>
                        <li class="nav-item"><a class="nav-link" href="<?php echo e(route('dashboard')); ?>">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo e(route('bookings.index')); ?>">My Bookings</a></li>
                    <?php endif; ?>
                </ul>
                <div class="d-flex align-items-center flex-wrap gap-2">
                    <?php if(auth()->guard()->check()): ?>
                        <div class="dropdown me-2">
                            <a href="#" class="navbar-text dropdown-toggle d-flex align-items-center gap-2" data-bs-toggle="dropdown">
                                <span style="width:28px;height:28px;border-radius:50%;background:rgba(245,148,31,.22);display:inline-flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:.75rem;">
                                    <?php echo e(strtoupper(substr(auth()->user()->name, 0, 1))); ?>

                                </span>
                                <?php echo e(auth()->user()->name); ?>

                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <?php if(auth()->user()->isAdmin()): ?>
                                    <li><a class="dropdown-item" href="<?php echo e(route('admin.dashboard')); ?>"><i class="bi bi-speedometer2 me-1"></i>Admin Dashboard</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                <?php endif; ?>
                                <li><a class="dropdown-item" href="<?php echo e(route('profile.edit')); ?>">Profile</a></li>
                                <li><a class="dropdown-item" href="<?php echo e(route('bookings.index')); ?>">My Bookings</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="<?php echo e(route('logout')); ?>">
                                        <?php echo csrf_field(); ?>
                                        <button class="dropdown-item">Log Out</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <a href="<?php echo e(route('login')); ?>" class="btn btn-hotel-outline btn-sm me-2">Login</a>
                        <a href="<?php echo e(route('register')); ?>" class="btn btn-orange btn-sm">Register</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <?php if (! empty(trim($__env->yieldContent('hero')))): ?>
        <div class="hotel-hero">
            <div class="container">
                <?php echo $__env->yieldContent('hero'); ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="container pb-5 <?php if (! empty(trim($__env->yieldContent('hero')))): ?> pt-0 <?php else: ?> pt-4 <?php endif; ?>">
        <?php if(session('success')): ?>
            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php echo $__env->yieldContent('content'); ?>
    </div>

    <?php if (! (request()->routeIs('dashboard') || request()->routeIs('rooms.create') || request()->routeIs('rooms.edit'))): ?>
        <footer class="site-footer">
            <div class="container">
                <div class="row g-4">
                    <div class="col-lg-4 col-md-6">
                        <a class="navbar-brand mb-2 d-inline-flex" href="<?php echo e(url('/')); ?>">
                            <span class="brand-mark"><img src="<?php echo e(asset('images/staypinas-mark.svg')); ?>" alt="StayPinas" style="width:100%;height:100%;object-fit:contain;"></span>
                            StayPinas
                        </a>
                        <p class="small mt-2">Your perfect stay starts here. Comfort, elegance, and memories in every room.</p>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <h6>Quick Links</h6>
                        <ul class="list-unstyled d-flex flex-column gap-2">
                            <li><a href="<?php echo e(url('/')); ?>">Home</a></li>
                            <li><a href="<?php echo e(route('rooms.index')); ?>">Rooms</a></li>
                            <li><a href="<?php echo e(route('bookings.create')); ?>">Book a Room</a></li>
                            <?php if(auth()->guard()->guest()): ?>
                                <li><a href="<?php echo e(route('register')); ?>">Register</a></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <h6>Contact Us</h6>
                        <ul class="list-unstyled d-flex flex-column gap-2">
                            <li><i class="bi bi-geo-alt me-1"></i> Pangasinan, Philippines</li>
                            <li><i class="bi bi-telephone me-1"></i> +63 917 123 4567</li>
                            <li><i class="bi bi-envelope me-1"></i> info@casaalvin.ph</li>
                        </ul>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <h6>Follow Us</h6>
                        <a href="#" class="social-icon"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="social-icon"><i class="bi bi-instagram"></i></a>
                    </div>
                </div>
                <div class="footer-bottom">&copy; <?php echo e(date('Y')); ?> StayPinas. All rights reserved.</div>
            </div>
        </footer>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>

    <script>
        // Scroll-reveal: fades/slides elements with class="reveal" into view as the user scrolls.
        (function () {
            var items = document.querySelectorAll('.reveal');
            if (!items.length) return;

            if (!('IntersectionObserver' in window)) {
                items.forEach(function (el) { el.classList.add('in-view'); });
                return;
            }

            var observer = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('in-view');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.15, rootMargin: '0px 0px -40px 0px' });

            items.forEach(function (el) { observer.observe(el); });
        })();
    </script>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\alvinjay\resources\views/layouts/booking.blade.php ENDPATH**/ ?>