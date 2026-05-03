<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Failed - SugarLoom PH</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --rose: #9d4f5d;
            --pink: #ff9daf;
            --blush: #fff7f7;
            --ink: #251f22;
            --muted: #75676c;
            --brown: #815f57;
            --line: #f1e8e8;
            --pink-nav: #e06b87;
            --white: #ffffff;
            --text-dark: #1a1018;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'DM Sans', sans-serif;
            background: var(--blush);
            color: var(--ink);
            display: grid;
            grid-template-rows: auto 1fr auto;
        }

        a { color: inherit; text-decoration: none; }

        .navbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 4rem;
            height: 70px;
            background: var(--pink-nav);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .logo {
            font-size: 1.1rem;
            font-weight: 900;
            color: white;
            letter-spacing: 0;
            text-decoration: none;
        }

        .nav-links {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 2.5rem;
        }

        .nav-links a {
            color: var(--white);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 400;
            transition: opacity 0.2s;
        }
        .nav-links form { margin: 0; }
        .nav-links button {
            background: transparent;
            border: 0;
            color: var(--white);
            cursor: pointer;
            font: inherit;
            padding: 0;
        }

        .nav-links a:hover,
        .nav-links button:hover { opacity: 0.8; }

        .nav-actions { display: flex; gap: 0.8rem; }

        .nav-actions > button,
        .nav-actions > a,
        .nav-actions > span {
            width: 38px; height: 38px;
            border-radius: 50%;
            border: 1px solid rgba(255,255,255,0.5);
            background: transparent;
            color: var(--text-dark);
            cursor: pointer;
            display: grid;
            place-items: center;
            transition: background 0.2s;
            padding: 0;
        }

        .nav-actions > button:hover,
        .nav-actions > a:hover,
        .nav-actions > span:hover { background: rgba(255,255,255,0.2); }

        .nav-actions svg { width: 16px; height: 16px; fill: currentColor; }

        .login-btn { background: transparent; border: 0; font: inherit; }

        .page {
            display: grid;
            place-items: center;
            padding: 54px 20px;
        }

        .panel {
            width: min(100%, 560px);
            background: #fff;
            border-radius: 28px;
            padding: 44px;
            text-align: center;
            box-shadow: 0 18px 44px rgba(157, 79, 93, 0.12);
        }

        .status-icon {
            width: 74px;
            height: 74px;
            margin: 0 auto 24px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            background: #fff0f2;
            color: var(--rose);
            font-size: 40px;
            font-weight: 800;
        }

        h1 {
            margin: 0 0 12px;
            font-size: clamp(30px, 5vw, 44px);
            letter-spacing: 0;
        }

        p {
            margin: 0 auto;
            max-width: 390px;
            color: var(--muted);
            line-height: 1.55;
        }

        .actions {
            display: flex;
            justify-content: center;
            gap: 14px;
            margin-top: 34px;
            flex-wrap: wrap;
        }

        .button {
            min-height: 50px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            padding: 0 22px;
            font-weight: 800;
        }

        .button.primary {
            background: linear-gradient(90deg, var(--rose), var(--pink));
            color: #fff;
            box-shadow: 0 10px 20px rgba(157, 79, 93, 0.18);
        }

        .button.secondary {
            background: #f8eeee;
            color: var(--brown);
        }

        .footer {
            background: #f4f4f4;
            padding: 30px 42px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #81787b;
            font-size: 14px;
        }

        .footer strong {
            color: #a30f3b;
            display: block;
            font-size: 18px;
            margin-bottom: 8px;
        }

        @media (max-width: 680px) {
            .nav-links { display: none; }
            .navbar { padding: 0 2rem; }
            .panel { padding: 34px 22px; }
            .footer {
                display: grid;
                gap: 8px;
                padding: 26px 20px;
            }
        }
        @include('partials.navbar-styles')
        @include('partials.login-modal-styles')
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="{{ route('home') }}" class="logo">SugarLoom PH</a>
        <div class="nav-links">
            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}">Admin</a>
                @else
                    <a href="{{ route('catalog') }}">Catalog</a>
                    <a href="{{ route('track-order') }}">Track Order</a>
                    <a href="{{ route('about') }}">About Us</a>
                @endif
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            @else
                <a href="{{ route('catalog') }}">Catalog</a>
                <a href="{{ route('track-order') }}">Track Order</a>
                <a href="{{ route('about') }}">About Us</a>
            @endauth
        </div>
        <div class="nav-actions">
            <a href="{{ route('cart.index') }}" aria-label="Cart">
                <svg viewBox="0 0 24 24"><path d="M7 18c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.6-1.35 2.44A2 2 0 0 0 7 17h12v-2H7.42l1.1-2h7.45c.75 0 1.41-.41 1.75-1.03L21 6H5.21l-.94-2H1zm16 16c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/></svg>
                @php($cartCount = collect(session('cart', []))->sum('quantity'))
                <span class="cart-count {{ $cartCount ? '' : 'is-empty' }}" data-cart-count>{{ $cartCount }}</span>
            </a>
            @auth
                <a href="{{ route('profile.edit') }}" aria-label="Account" title="Account">
                    <svg viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                </a>
            @else
                <button type="button" class="login-btn" data-login-open aria-label="Login" title="Login">
                    <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/></svg>
                </button>
            @endauth
        </div>
    </nav>

    @include('partials.login-modal')

    <main class="page">
        <section class="panel">
            <div class="status-icon">!</div>
            <h1>{{ $message ?? 'Payment failed, please try again.' }}</h1>
            <p>Your payment was not completed. Your cart is still saved, so you can return to checkout and start a fresh PayMongo payment session.</p>
            <div class="actions">
                <a class="button primary" href="{{ route('cart.index') }}">Try Again</a>
                <a class="button secondary" href="{{ route('catalog') }}">Back to Catalog</a>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div>
            <strong>SugarLoom PH</strong>
            <span>© 2024 SugarLoom PH. Baked with artisanal care.</span>
        </div>
        <span>Secure checkout powered by PayMongo</span>
    </footer>
    @include('partials.login-modal-script')
</body>
</html>
