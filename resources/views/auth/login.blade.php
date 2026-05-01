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
            background: var(--cream);
            color: var(--text-body);
            font-family: 'Poppins', sans-serif;
            overflow: hidden;
        }

        .page-backdrop {
            min-height: 100vh;
            background:
                radial-gradient(circle at 83% 16%, rgba(255,255,255,0.88) 0 18rem, transparent 18.1rem),
                linear-gradient(110deg, var(--pink-bg), #fff4ef 62%, #f6e2db);
            filter: blur(4px);
            transform: scale(1.02);
        }

        .navbar {
            align-items: center;
            background: var(--pink-nav);
            display: flex;
            height: 70px;
            justify-content: space-between;
            padding: 0 4rem;
        }

        .logo {
            color: var(--white);
            font-size: 1.1rem;
            font-weight: 900;
            text-decoration: none;
        }

        .nav-links {
            display: flex;
            gap: 2.5rem;
        }

        .nav-links a {
            color: var(--white);
            font-size: 0.9rem;
            font-weight: 400;
            text-decoration: none;
        }

        .hero-backdrop {
            min-height: calc(100vh - 70px);
            display: grid;
            grid-template-columns: 1fr 460px;
            gap: 5rem;
            align-items: center;
            padding: 4rem 5rem;
        }

        .hero-copy h1 {
            color: var(--text-dark);
            font-size: clamp(4rem, 7vw, 7rem);
            font-weight: 900;
            letter-spacing: 0;
            line-height: 0.95;
            margin-bottom: 2rem;
        }

        .hero-copy h1 span {
            color: var(--text-accent);
            display: block;
        }

        .hero-copy p {
            font-size: 1.15rem;
            font-weight: 300;
            line-height: 1.65;
            max-width: 620px;
        }

        .modal-layer {
            align-items: center;
            background: rgba(255, 255, 255, 0.18);
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(340px, 550px);
            gap: 5rem;
            inset: 0;
            padding: 5.3rem 5rem 3rem;
            position: fixed;
            z-index: 10;
        }

        .modal-copy {
            padding-left: 0.25rem;
        }

        .modal-copy h1 {
            color: var(--text-dark);
            font-size: clamp(4rem, 7vw, 6.7rem);
            font-weight: 900;
            letter-spacing: 0;
            line-height: 0.95;
            margin-bottom: 2rem;
        }

        .modal-copy h1 span {
            color: var(--text-accent);
            display: block;
        }

        .modal-copy p {
            color: var(--text-body);
            font-size: 1.08rem;
            font-weight: 300;
            line-height: 1.7;
            max-width: 590px;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.96);
            border: 1px solid rgba(255, 255, 255, 0.75);
            border-radius: 28px;
            box-shadow: var(--shadow-card);
            padding: 3.1rem;
            position: relative;
        }

        .close {
            align-items: center;
            background: #fff7f9;
            border: 1px solid #f3d7df;
            border-radius: 50%;
            color: var(--text-muted);
            display: flex;
            font-size: 1.2rem;
            height: 38px;
            justify-content: center;
            line-height: 1;
            position: absolute;
            right: 1.4rem;
            text-decoration: none;
            top: 1.4rem;
            width: 38px;
        }

        .close:hover {
            color: var(--pink-btn);
        }

        .login-card h2 {
            color: var(--text-dark);
            font-size: 2rem;
            font-weight: 900;
            margin-bottom: 0.6rem;
        }

        .subtext {
            color: var(--text-muted);
            font-size: 1rem;
            margin-bottom: 2.2rem;
        }

        .status,
        .error-list {
            border-radius: 16px;
            font-size: 0.88rem;
            line-height: 1.5;
            margin-bottom: 1rem;
            padding: 0.85rem 1rem;
        }

        .status {
            background: #ecfdf3;
            color: #166534;
        }

        .error-list {
            background: #fff1f2;
            color: #be123c;
        }

        .field {
            margin-bottom: 1.35rem;
        }

        label {
            color: var(--text-dark);
            display: block;
            font-size: 0.9rem;
            font-weight: 800;
            margin-bottom: 0.65rem;
        }

        input[type="email"],
        input[type="password"] {
            background: var(--input-bg);
            border: 1.5px solid #f0d8df;
            border-radius: 999px;
            color: var(--text-dark);
            font: inherit;
            outline: none;
            padding: 1rem 1.25rem;
            transition: border-color 0.2s, box-shadow 0.2s;
            width: 100%;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #ef7fa1;
            box-shadow: 0 0 0 4px rgba(239, 127, 161, 0.25);
        }

        .row {
            align-items: center;
            display: flex;
            gap: 1rem;
            justify-content: space-between;
            margin: 0.3rem 0 2rem;
        }

        .remember {
            align-items: center;
            color: var(--text-muted);
            display: flex;
            font-size: 0.9rem;
            font-weight: 700;
            gap: 0.55rem;
            margin: 0;
        }

        .remember input {
            accent-color: var(--pink-btn);
            height: 15px;
            width: 15px;
        }

        .forgot,
        .register a {
            color: var(--pink-deep);
            font-size: 0.9rem;
            font-weight: 800;
            text-decoration: none;
        }

        .submit {
            background: #cf567c;
            border: 0;
            border-radius: 999px;
            box-shadow: 0 18px 36px rgba(206, 90, 122, 0.28);
            color: var(--white);
            cursor: pointer;
            font: inherit;
            font-size: 1rem;
            font-weight: 900;
            padding: 1rem 1.4rem;
            transition: transform 0.2s, box-shadow 0.2s;
            width: 100%;
        }

        .submit:hover {
            box-shadow: 0 20px 42px rgba(206, 90, 122, 0.34);
            transform: translateY(-1px);
        }

        .register {
            color: var(--text-muted);
            font-size: 0.92rem;
            margin-top: 1.7rem;
            text-align: center;
        }

        @media (max-width: 1000px) {
            body { overflow: auto; }
            .page-backdrop { display: none; }
            .modal-layer {
                background: linear-gradient(135deg, var(--pink-bg), var(--cream));
                grid-template-columns: 1fr;
                min-height: 100vh;
                padding: 2rem;
                position: static;
            }
            .modal-copy h1 { font-size: 3.2rem; }
            .login-card { max-width: 560px; width: 100%; }
        }

        @media (max-width: 560px) {
            .modal-layer { padding: 1rem; }
            .modal-copy { display: none; }
            .login-card {
                border-radius: 22px;
                padding: 2rem 1.4rem;
            }
            .row {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="page-backdrop" aria-hidden="true">
        <nav class="navbar">
            <a href="{{ route('home') }}" class="logo">SugarLoom PH</a>
            <div class="nav-links">
                <a href="{{ route('home') }}">Home</a>
                <a href="{{ route('catalog') }}">Catalog</a>
                <a href="{{ route('about') }}">Our Story</a>
            </div>
        </nav>

        <section class="hero-backdrop">
            <div class="hero-copy">
                <h1>Welcome back,<span>sweet soul.</span></h1>
                <p>Sign in to continue shopping small-batch treats, track your orders, or manage the SugarLoom dashboard.</p>
            </div>
            <div></div>
        </section>
    </div>

    <main class="modal-layer" role="dialog" aria-modal="true" aria-labelledby="login-title">
        <section class="modal-copy">
            <h1>Welcome back,<span>sweet soul.</span></h1>
            <p>Sign in to continue shopping small-batch treats, track your orders, or manage the SugarLoom dashboard.</p>
        </section>

        <section class="login-card">
            <a href="{{ route('home') }}" class="close" aria-label="Close login modal">&times;</a>

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
    </main>
</body>
</html>
