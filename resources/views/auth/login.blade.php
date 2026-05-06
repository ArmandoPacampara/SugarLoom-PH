<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - SugarLoom PH</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --pink-nav: #e06b87;
            --pink-bg: #f6ccd6;
            --pink-btn: #ce5a7a;
            --pink-deep: #d8547b;
            --cream: #fdf6f0;
            --white: #ffffff;
            --input-bg: #edf5ff;
            --text-dark: #2b1b24;
            --text-accent: #835372;
            --text-body: #665560;
            --text-muted: #8a7080;
            --shadow-card: 0 24px 70px rgba(201, 75, 118, 0.22);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            min-height: 100vh;
            font-family: 'Poppins', sans-serif;
            overflow: hidden;
            position: relative;
        }

        /* ── Blurred site background ── */
        .site-behind {
            position: fixed;
            inset: 0;
            z-index: 0;
            filter: blur(3px) brightness(0.85);
            background: linear-gradient(110deg, var(--pink-bg), #fff4ef 62%, #f6e2db);
        }

        /* ── Dark overlay — hidden by default ── */
        .overlay {
            position: fixed;
            inset: 0;
            background: rgba(80, 20, 40, 0.35);
            z-index: 2;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease;
        }

        .overlay.active {
            opacity: 1;
            visibility: visible;
        }

        /* ── Popup card ── */
        .popup {
            background: #fce8ee;
            border-radius: 28px;
            box-shadow: 0 32px 80px rgba(180, 50, 90, 0.30);
            display: grid;
            grid-template-columns: 1fr 420px;
            max-width: 960px;
            min-height: 520px;
            overflow: hidden;
            position: relative;
            width: 100%;
            z-index: 3;
            animation: popIn 0.45s cubic-bezier(0.34, 1.56, 0.64, 1) both;
            animation-play-state: paused;
        }

        .overlay.active .popup {
            animation-play-state: running;
        }

        @keyframes popIn {
            0%   { opacity: 0; transform: scale(0.85) translateY(24px); }
            70%  { transform: scale(1.02) translateY(-4px); }
            100% { opacity: 1; transform: scale(1) translateY(0); }
        }

        /* ── Left copy panel ── */
        .popup-copy {
            padding: 3.5rem 2.5rem 3.5rem 3.5rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .popup-copy h1 {
            color: var(--text-dark);
            font-size: clamp(2.6rem, 5vw, 4.2rem);
            font-weight: 900;
            line-height: 1.0;
            margin-bottom: 1.5rem;
        }

        .popup-copy h1 span {
            color: var(--text-accent);
            display: block;
        }

        .popup-copy p {
            color: var(--text-body);
            font-size: 1rem;
            font-weight: 300;
            line-height: 1.7;
            max-width: 360px;
        }

        /* ── Right form panel ── */
        .login-card {
            background: rgba(255, 255, 255, 0.97);
            border-radius: 22px;
            box-shadow: -8px 0 40px rgba(201, 75, 118, 0.10);
            margin: 16px;
            padding: 2.8rem 2.6rem;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        /* Close button */
        .close {
            align-items: center;
            background: #fff7f9;
            border: 1px solid #f3d7df;
            border-radius: 50%;
            color: var(--text-muted);
            display: flex;
            font-size: 1.15rem;
            height: 34px;
            justify-content: center;
            line-height: 1;
            position: absolute;
            right: 1.2rem;
            text-decoration: none;
            top: 1.2rem;
            width: 34px;
            transition: color 0.2s;
        }

        .close:hover { color: var(--pink-btn); }

        .login-card h2 {
            color: var(--text-dark);
            font-size: 1.9rem;
            font-weight: 900;
            margin-bottom: 0.4rem;
        }

        .subtext {
            color: var(--text-muted);
            font-size: 0.95rem;
            margin-bottom: 1.8rem;
            line-height: 1.5;
        }

        /* Alerts */
        .status,
        .error-list {
            border-radius: 14px;
            font-size: 0.87rem;
            line-height: 1.5;
            margin-bottom: 1rem;
            padding: 0.8rem 1rem;
        }

        .status      { background: #ecfdf3; color: #166534; }
        .error-list  { background: #fff1f2; color: #be123c; }

        /* Fields */
        .field { margin-bottom: 1.2rem; }

        label {
            color: var(--text-dark);
            display: block;
            font-size: 0.88rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
        }

        .field-hint {
            color: var(--text-muted);
            font-size: 0.78rem;
            font-weight: 400;
            margin-top: 0.35rem;
        }

        input[type="email"],
        input[type="password"] {
            background: var(--input-bg);
            border: 1.5px solid #dce8f8;
            border-radius: 999px;
            color: var(--text-dark);
            font: inherit;
            outline: none;
            padding: 0.85rem 1.2rem;
            transition: border-color 0.2s, box-shadow 0.2s;
            width: 100%;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #ef7fa1;
            box-shadow: 0 0 0 4px rgba(239, 127, 161, 0.20);
        }

        /* Remember + forgot row */
        .row {
            align-items: center;
            display: flex;
            gap: 1rem;
            justify-content: space-between;
            margin: 0.2rem 0 1.6rem;
        }

        .remember {
            align-items: center;
            color: var(--text-muted);
            display: flex;
            font-size: 0.88rem;
            font-weight: 600;
            gap: 0.5rem;
        }

        .remember input {
            accent-color: var(--pink-btn);
            height: 15px;
            width: 15px;
        }

        .forgot {
            color: var(--pink-deep);
            font-size: 0.88rem;
            font-weight: 800;
            text-decoration: none;
        }

        /* Submit button */
        .submit {
            background: linear-gradient(135deg, #d95f82, #c4496e);
            border: 0;
            border-radius: 999px;
            box-shadow: 0 12px 28px rgba(206, 90, 122, 0.30);
            color: var(--white);
            cursor: pointer;
            font: inherit;
            font-size: 1rem;
            font-weight: 900;
            padding: 0.9rem 1.4rem;
            transition: transform 0.2s, box-shadow 0.2s;
            width: 100%;
        }

        .submit:hover {
            box-shadow: 0 16px 36px rgba(206, 90, 122, 0.38);
            transform: translateY(-1px);
        }

        /* Register link */
        .register {
            color: var(--text-muted);
            font-size: 0.9rem;
            margin-top: 1.4rem;
            text-align: center;
        }

        .register a {
            color: var(--pink-deep);
            font-weight: 800;
            text-decoration: none;
        }

        /* ── Responsive ── */
        @media (max-width: 780px) {
            .popup {
                grid-template-columns: 1fr;
                max-width: 480px;
            }
            .popup-copy { display: none; }
            .login-card { margin: 0; border-radius: 28px; }
        }

        @media (max-width: 520px) {
            .overlay { padding: 0.75rem; }
            .login-card { padding: 2rem 1.4rem; }
            .row { flex-direction: column; align-items: flex-start; }
        }
    </style>
</head>
<body>

    <!-- Blurred background -->
    <div class="site-behind" aria-hidden="true"></div>

    <!-- Overlay + popup -->
    <div class="overlay" id="modal-overlay">
        <div class="popup" role="dialog" aria-modal="true" aria-labelledby="login-title">

            <!-- Left copy -->
            <section class="popup-copy">
                <h1>Welcome back,<span>sweet soul.</span></h1>
                <p>Sign in to continue shopping small-batch treats, track your orders, or manage the SugarLoom dashboard.</p>
            </section>

            <!-- Right form -->
            <section class="login-card">
                <a href="{{ route('home') }}" class="close" aria-label="Close">&times;</a>

                <h2 id="login-title">Log in</h2>
                <p class="subtext">Use your SugarLoom account to continue.</p>

                @if (session('status'))
                    <div class="status">{{ session('status') }}</div>
                @endif

                @if ($errors->any())
                    <div class="error-list">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="field">
                        <label for="email">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                        <p class="field-hint">Never shown to the public.</p>
                    </div>

                    <div class="field">
                        <label for="password">Password</label>
                        <input id="password" type="password" name="password" required autocomplete="current-password">
                    </div>

                    <div class="row">
                        <label class="remember" for="remember_me">
                            <input id="remember_me" type="checkbox" name="remember">
                            <span>Remember me</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="forgot" href="{{ route('password.request') }}">Forgot password?</a>
                        @endif
                    </div>

                    <button type="submit" class="submit">Log in</button>
                </form>

                @if (Route::has('register'))
                    <p class="register">New here? <a href="{{ route('register') }}">Create an account</a></p>
                @endif
            </section>

        </div>
    </div>

    <script>
        window.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => {
                document.getElementById('modal-overlay').classList.add('active');
            }, 100);
        });
    </script>

</body>
</html>