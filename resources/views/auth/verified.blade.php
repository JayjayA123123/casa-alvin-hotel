<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Email Verified - StayPinas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        :root { --ink:#17233d; --navy:#17233d; --navy-dark:#101929; --orange:#f5941f; --success:#1c8a52; --text-muted:#6b7385; }
        * { box-sizing: border-box; }
        body { margin:0; font-family:'Inter',sans-serif; background:#fff; color: var(--ink); }
        h1 { font-family:'Poppins', sans-serif; }
        a { color: var(--orange); text-decoration: none; }
        .auth-success-wrap { min-height:100vh; display:flex; align-items:center; justify-content:center; }
        .auth-success-card { text-align:center; max-width:420px; padding:1rem 2rem; }
        .auth-success-icon { width:76px; height:76px; border-radius:50%; background: var(--success); color:#fff; display:inline-flex; align-items:center; justify-content:center; font-size:2rem; margin-bottom:1.5rem; }
        .auth-success-card h1 { font-size:1.7rem; font-weight:700; margin-bottom:.6rem; }
        .auth-success-card p { color: var(--text-muted); margin-bottom:1.6rem; }
        .btn-primary { background: var(--navy); border:1px solid var(--navy); color:#fff; font-weight:700; border-radius:9px; padding:.7rem 1.4rem; }
        .btn-primary:hover { color:#fff; background: var(--navy-dark); }
    </style>
</head>
<body>
    <div class="auth-success-wrap">
        <div class="auth-success-card">
            <span class="auth-success-icon"><i class="bi bi-check-lg"></i></span>
            <h1>Email Verified!</h1>
            <p>Your email has been successfully verified. You can now sign in to your account.</p>
            <a href="{{ route('login') }}" class="btn btn-primary">Sign In Now</a>
            <div class="mt-3"><a href="{{ route('dashboard') }}">Go to Home Page</a></div>
        </div>
    </div>
</body>
</html>
