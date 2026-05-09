<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email | SugarLoom PH</title>
    <style>
        :root { --pink-deep: #d8547b; --pink-nav: #e06b87; --pink-pale: #ffd7e1; --text-body: #4a3d45; }
        body { margin: 0; font-family: Arial, sans-serif; background: #fdf2f8; color: #111827; }
        .navbar { display: flex; align-items: center; justify-content: space-between; padding: 0 4rem; height: 70px; background: var(--pink-nav); }
        .logo { font-size: 1.1rem; font-weight: 900; color: white; text-decoration: none; }
        .container { max-width: 520px; margin: 54px auto; padding: 0 24px; }
        .card { background: white; padding: 30px; border-radius: 20px; box-shadow: 0 8px 20px rgba(0,0,0,0.05); }
        h2 { font-size: 24px; margin-top: 0; text-align: center; color: var(--pink-deep); }
        p { color: var(--text-body); text-align: center; }
        label { display: block; font-size: 14px; font-weight: bold; color: var(--text-body); margin-bottom: 6px; }
        input { width: 100%; padding: 14px; border: 1px solid #e5e7eb; border-radius: 10px; box-sizing: border-box; font-size: 18px; text-align: center; letter-spacing: 6px; font-weight: 700; }
        input:focus { outline: none; border-color: var(--pink-nav); box-shadow: 0 0 0 3px var(--pink-pale); }
        .btn-primary { background: #fb7185; color: white; border: none; padding: 12px; border-radius: 999px; font-weight: bold; cursor: pointer; width: 100%; font-size: 16px; margin-top: 16px; }
        .btn-link { border: 0; background: transparent; color: var(--pink-deep); font-weight: 700; cursor: pointer; margin-top: 14px; }
        .alert-error, .alert-success { padding: 12px; border-radius: 10px; margin-bottom: 18px; font-size: 14px; }
        .alert-error { background: #fee2e2; color: #b91c1c; }
        .alert-success { background: #dcfce7; color: #166534; }
        .text-center { text-align: center; }
    </style>
</head>
<body>
<nav class="navbar">
    <a href="{{ route('home') }}" class="logo">SugarLoom PH</a>
</nav>

<div class="container">
    <div class="card">
        <h2>Verify Your Email</h2>
        <p>We sent a six-digit code to <strong>{{ $email }}</strong>.</p>

        @if (session('status'))
            <div class="alert-success">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert-error">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('register.verify') }}">
            @csrf
            <label for="code">Verification Code</label>
            <input id="code" type="text" name="code" inputmode="numeric" maxlength="6" required autofocus placeholder="000000">
            <button type="submit" class="btn-primary">Create Account</button>
        </form>

        <form method="POST" action="{{ route('register.resend-code') }}" class="text-center">
            @csrf
            <button type="submit" class="btn-link">Send a new code</button>
        </form>
    </div>
</div>
</body>
</html>
