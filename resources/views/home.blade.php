<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SugarLoom PH – Where Sweet Dreams Are Woven</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            /* Exact color matching from screenshot */
            --pink-nav:    #e06b87;
            --pink-bg-base:#f6ccd6;
            --pink-btn:    #ce5a7a;
           
            --text-dark:   #2b1b24; /* Dark plum for logo and headings */
            --text-accent: #835372; /* Muted purple for "woven!" */
            --text-body:   #665560; /* Paragraph text */
           
            --cream:       #fdf6f0;
            --white:       #ffffff;
            --radius-card: 20px;
            --shadow-card: 0 8px 32px rgba(201,75,118,0.10);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--cream);
            color: var(--text-body);
            overflow-x: hidden;
        }

        h1, h2, h3 {
            font-family: 'Poppins', sans-serif;
            color: var(--text-dark);
            letter-spacing: -0.03em;
        }

        /* ── NAVBAR ── */
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
            position: relative;
        }
       
        .nav-actions > button:hover,
        .nav-actions > a:hover,
        .nav-actions > span:hover { background: rgba(255,255,255,0.2); }
       
        .nav-actions svg { width: 16px; height: 16px; fill: currentColor; }

        .cart-count {
            position: absolute;
            top: -9px;
            right: -7px;
            color: white;
            font-size: 0.72rem;
            font-weight: 800;
            line-height: 1;
            text-shadow: 0 1px 2px rgba(43, 27, 36, 0.45);
        }

        .cart-count.is-empty { display: none; }

        body.modal-open {
            overflow: hidden;
        }

        .login-overlay {
            align-items: center;
            background: rgba(43, 27, 36, 0.48);
            backdrop-filter: blur(8px);
            display: none;
            inset: 0;
            justify-content: center;
            padding: 2rem;
            position: fixed;
            z-index: 999;
        }

        .login-overlay.is-open {
            display: flex;
        }

        .login-popup {
            background:
                radial-gradient(circle at 88% 16%, rgba(255,255,255,0.95) 0 10rem, transparent 10.2rem),
                linear-gradient(105deg, #f7cbd5 0%, #fff5f0 100%);
            border: 1px solid rgba(255,255,255,0.8);
            border-radius: 26px;
            box-shadow: 0 28px 80px rgba(43, 27, 36, 0.28);
            display: grid;
            grid-template-columns: minmax(0, 0.95fr) minmax(320px, 0.82fr);
            gap: 1.5rem;
            max-width: 920px;
            min-height: 480px;
            overflow: hidden;
            padding: 2.1rem;
            position: relative;
            width: min(100%, 920px);
        }

        .login-copy {
            align-self: center;
            padding: 1rem 0.5rem 1rem 0.7rem;
        }

        .login-copy h2 {
            color: var(--text-dark);
            font-size: clamp(2.9rem, 5vw, 4.6rem);
            font-weight: 900;
            letter-spacing: 0;
            line-height: 0.96;
            margin-bottom: 1.15rem;
        }

        .login-copy h2 span {
            color: var(--text-accent);
            display: block;
        }

        .login-copy p {
            color: var(--text-body);
            font-size: 0.98rem;
            font-weight: 300;
            line-height: 1.65;
            max-width: 410px;
        }

        .login-panel {
            align-self: center;
            background: rgba(255,255,255,0.97);
            border: 1px solid rgba(255,255,255,0.8);
            border-radius: 22px;
            box-shadow: 0 18px 50px rgba(206, 90, 122, 0.18);
            padding: 2.25rem 2.25rem 1.8rem;
        }

        .login-panel h2 {
            color: var(--text-dark);
            font-size: 2rem;
            font-weight: 900;
            letter-spacing: 0;
            line-height: 1;
            margin-bottom: 0.55rem;
        }

        .login-panel .subtext {
            color: var(--text-muted);
            font-size: 0.94rem;
            margin-bottom: 1.55rem;
        }

        .login-close {
            background: rgba(255,255,255,0.72);
            border: 1px solid rgba(255,255,255,0.9);
            border-radius: 50%;
            color: var(--text-muted);
            cursor: pointer;
            font-size: 1.25rem;
            font-weight: 800;
            height: 34px;
            line-height: 1;
            position: absolute;
            right: 1rem;
            top: 1rem;
            width: 34px;
            z-index: 2;
        }

        .login-close:hover {
            color: var(--pink-btn);
        }

        .login-field {
            margin-bottom: 1rem;
        }

        .login-field label {
            color: var(--text-dark);
            display: block;
            font-size: 0.86rem;
            font-weight: 800;
            margin-bottom: 0.48rem;
        }

        .login-field input[type="email"],
        .login-field input[type="password"] {
            background: #edf5ff;
            border: 1.5px solid #f0c8d3;
            border-radius: 999px;
            color: var(--text-dark);
            font: inherit;
            font-size: 0.86rem;
            outline: none;
            padding: 0.82rem 1rem;
            width: 100%;
        }

        .login-field input:focus {
            border-color: #ef7fa1;
            box-shadow: 0 0 0 3px rgba(239, 127, 161, 0.2);
        }

        .login-hint {
            color: var(--text-muted);
            display: block;
            font-size: 0.66rem;
            margin-top: 0.26rem;
        }

        .login-row {
            align-items: center;
            display: flex;
            justify-content: space-between;
            gap: 0.75rem;
            margin: 1.1rem 0 1.35rem;
        }

        .login-remember {
            align-items: center;
            color: var(--text-body);
            display: flex;
            font-size: 0.82rem;
            font-weight: 700;
            gap: 0.45rem;
        }

        .login-remember input {
            accent-color: var(--pink-btn);
        }

        .login-forgot,
        .login-register a {
            color: var(--pink-btn);
            font-size: 0.82rem;
            font-weight: 800;
            text-decoration: none;
        }

        .login-submit {
            background: var(--pink-btn);
            border: 0;
            border-radius: 999px;
            box-shadow: 0 12px 28px rgba(206, 90, 122, 0.28);
            color: var(--white);
            cursor: pointer;
            font: inherit;
            font-size: 0.92rem;
            font-weight: 900;
            padding: 0.86rem 1rem;
            width: 100%;
        }

        .login-register {
            color: var(--text-muted);
            font-size: 0.84rem;
            margin-top: 1.25rem;
            text-align: center;
        }

        .login-errors,
        .login-status {
            border-radius: 12px;
            font-size: 0.74rem;
            line-height: 1.45;
            margin-bottom: 0.85rem;
            padding: 0.65rem 0.75rem;
        }

        .login-errors {
            background: #fff1f2;
            color: #be123c;
        }

        .login-status {
            background: #ecfdf3;
            color: #166534;
        }


        /* ── HERO ── */
        .hero {
            background-color: var(--pink-bg-base);
            min-height: calc(100vh - 70px);
            display: flex;
            align-items: center;
            padding: 0 4rem;
            position: relative;
            overflow: hidden;
        }

        /* The distinct curved shape behind the cookies */
        .hero::before {
            content: '';
            position: absolute;
            top: -10%;
            right: -10%;
            width: 65vw;
            height: 120vh;
            background: linear-gradient(135deg, #fef4f6 0%, #f1a9bf 80%);
            border-radius: 50% 0 0 50%;
            z-index: 1;
        }

        .hero-text {
            width: 65%;           /* Increased from 55% */
            max-width: 750px;     /* Increased from 600px */
            position: relative;
            z-index: 3;
            margin-top: -2rem;
        }

        .hero-text h1 {
            font-size: clamp(3.5rem, 6vw, 5.5rem);
            line-height: 0.95; /* Extra tight to match design */
            font-weight: 900;
            margin-bottom: 1.5rem;
            letter-spacing: -0.04em;
        }

        .hero-text h1 .accent {
            color: var(--text-accent);
            display: block;
        }

        .hero-text p {
            font-size: 0.95rem;
            font-weight: 300;
            line-height: 1.8;
            max-width: 440px;
            margin-bottom: 2.5rem;
        }

        .hero-buttons { display: flex; gap: 1.25rem; flex-wrap: wrap; }

        .btn {
            border-radius: 999px;
            padding: 0.85rem 2.2rem;
            font-size: 0.95rem;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
            border: none;
            transition: transform 0.2s, box-shadow 0.2s;
            text-decoration: none;
            display: inline-block;
        }
       
        .btn:hover { transform: translateY(-2px); }
       
        .btn-primary {
            background: var(--pink-btn);
            color: white;
            box-shadow: 0 8px 24px rgba(206, 90, 122, 0.3);
        }
       
        .btn-white {
            background: var(--white);
            color: var(--text-body);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.05);
        }

        .hero-image {
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 45%;
            max-width: 700px;
            z-index: 2;
            display: flex;
            justify-content: flex-end;
        }
       
        .hero-image img {
            width: 100%;
            display: block;
            object-fit: contain;
        }


        /* ── SECTION COMMONS ── */
        .section { padding: 5rem 4rem; }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 3rem;
        }

        .section-header h2 { font-size: 2.5rem; font-weight: 800; }
        .section-header p { font-size: 1rem; color: var(--text-body); margin-top: 0.5rem; font-weight: 300; }

        .view-all {
            font-size: 0.95rem;
            color: var(--pink-btn);
            font-weight: 600;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.3rem;
            white-space: nowrap;
            transition: gap 0.2s;
        }
        .view-all:hover { gap: 0.55rem; }


        /* ── BEST SELLERS ── */
        .best-sellers { background: var(--white); }


        .products-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
        }


        .product-card {
            border: 1px solid #f4e9ec;
            border-radius: var(--radius-card);
            overflow: hidden;
            background: var(--white);
            box-shadow: var(--shadow-card);
            transition: transform 0.25s, box-shadow 0.25s;
        }
       
        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 40px rgba(201,75,118,0.15);
        }


        .product-card-img {
            width: 100%;
            height: 240px;
            object-fit: cover;
            display: block;
            background: #fdf1f4;
        }


        .product-card-body { padding: 1.5rem; }


        .product-card-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 0.75rem;
        }
       
        .product-card-top h3 { font-size: 1.25rem; font-weight: 700; line-height: 1.2; }
        .product-price { font-weight: 700; font-size: 1.1rem; color: var(--pink-btn); }


        .product-desc { font-size: 0.9rem; font-weight: 300; line-height: 1.6; margin-bottom: 1.5rem; }


        .btn-add {
            width: 100%;
            padding: 0.8rem;
            border-radius: 999px;
            border: 1.5px solid #f0e1e5;
            background: white;
            color: var(--text-dark);
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            font-family: 'Poppins', sans-serif;
        }
       
        .btn-add:hover {
            background: var(--pink-btn);
            color: white;
            border-color: var(--pink-btn);
        }


        /* ── FLAVOR QUIZ CTA ── */
        .quiz-section { background: var(--cream); padding: 4rem; }


        .quiz-card {
            display: grid;
            grid-template-columns: 1fr 1fr;
            border-radius: 28px;
            overflow: hidden;
            min-height: 300px;
        }


    .quiz-img-wrap {
        flex: 1; /* Changed from 1.2 to 1 for perfect 50/50 balance */
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 3.5rem 3.5rem 3.5rem 0; /* Padding to give the image breathing room */
    }

    .quiz-img {
        width: 100%; 
        height: 100%;
        max-height: 330px; /* Prevents it from getting too tall */
        object-fit: cover; /* Ensures the image doesn't stretch/distort */
        object-position: center;
        border-radius: 16px; /* Rounds the image perfectly */
        box-shadow: 0 8px 24px rgba(0,0,0,0.12); /* Adds a subtle shadow for depth */
    }

        .quiz-content {
            background: #fae6eb;
            padding: 4rem 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 1.25rem;
        }
       
        .quiz-content h2 { font-size: 2.2rem; font-weight: 800; line-height: 1.2; }
        .quiz-content p { font-size: 1rem; font-weight: 300; line-height: 1.7; }


        .btn-quiz {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--pink-btn);
            color: white;
            border: none;
            border-radius: 999px;
            padding: 0.9rem 1.8rem;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            width: fit-content;
            transition: transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 8px 20px rgba(209, 91, 123, 0.25);
            font-family: 'Poppins', sans-serif;
        }
        .btn-quiz:hover { transform: translateY(-2px); }


        /* ── TESTIMONIALS ── */
        .testimonials { background: var(--white); }


        .testimonials .section-header {
            flex-direction: column;
            align-items: center;
            text-align: center;
            margin-bottom: 3.5rem;
        }


        .divider {
            width: 60px; height: 4px;
            background: var(--pink-btn);
            border-radius: 2px;
            margin: 1rem auto 0;
        }


        .reviews-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem; }


        .review-card {
            padding: 2.25rem;
            border: 1px solid #f4e9ec;
            border-radius: var(--radius-card);
            background: var(--cream);
        }


        .review-quote {
            font-size: 3.5rem;
            color: #f09ab0;
            line-height: 0.8;
            font-weight: 900;
            margin-bottom: 0.5rem;
        }


        .stars { color: #f4a623; font-size: 1rem; letter-spacing: 2px; margin-bottom: 1rem; }


        .review-text { font-size: 0.95rem; font-weight: 300; line-height: 1.7; margin-bottom: 1.5rem; }


        .reviewer { display: flex; align-items: center; gap: 1rem; }


        .reviewer-avatar {
            width: 44px; height: 44px;
            border-radius: 50%;
            background: #f09ab0;
            display: grid;
            place-items: center;
            font-size: 1.1rem;
            font-weight: 700;
            color: white;
            flex-shrink: 0;
            overflow: hidden;
        }
        .reviewer-avatar img { width: 100%; height: 100%; object-fit: cover; }


        .reviewer-name { font-size: 0.95rem; font-weight: 700; color: var(--text-dark); }
        .reviewer-role { font-size: 0.8rem; font-weight: 500; color: var(--pink-btn); text-transform: uppercase; letter-spacing: 0.05em; }


        /* ── TOAST ── */
        .toast {
            position: fixed;
            bottom: 2rem;
            left: 50%;
            transform: translateX(-50%) translateY(80px);
            background: var(--text-dark);
            color: white;
            padding: 0.8rem 1.8rem;
            border-radius: 999px;
            font-size: 0.95rem;
            font-weight: 500;
            z-index: 9999;
            transition: transform 0.3s ease;
            pointer-events: none;
        }
        .toast.show { transform: translateX(-50%) translateY(0); }


        /* ── FOOTER ── */
        footer {
            background: var(--pink-nav);
            padding: 2rem 4rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .footer-logo { font-size: 1.25rem; font-weight: 900; color: var(--text-dark); }
        .footer-cart {
            width: 44px; height: 44px;
            border-radius: 50%;
            background: rgba(255,255,255,0.2);
            border: 1px solid rgba(255,255,255,0.4);
            color: white;
            display: grid;
            place-items: center;
            font-size: 1.1rem;
            cursor: pointer;
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 1024px) {
            .hero-text h1 { font-size: 3.5rem; }
            .hero-image { width: 50%; }
        }

        @media (max-width: 900px) {
            .section { padding: 4rem 2rem; }
            .hero { padding: 4rem 2rem; flex-direction: column; align-items: flex-start; }
            .hero::before { width: 100vw; height: 100vw; top: 20%; right: 0; border-radius: 50%; }
            .hero-text { width: 100%; max-width: 100%; margin-bottom: 3rem; }
            .hero-image { position: relative; width: 100%; transform: none; display: flex; justify-content: center; }
            .hero-image img { width: 80%; }
            .products-grid, .reviews-grid { grid-template-columns: 1fr 1fr; }
            .quiz-card { grid-template-columns: 1fr; }
            .quiz-img { height: 260px; }
            .navbar { padding: 0 2rem; }
            .nav-links { display: none; }
            footer { padding: 2rem; }
        }

        @media (max-width: 600px) {
            .products-grid, .reviews-grid { grid-template-columns: 1fr; }
            .hero-text h1 { font-size: 3rem; }
            .hero-buttons { flex-direction: column; width: 100%; }
            .btn { text-align: center; width: 100%; }
            .login-popup {
                grid-template-columns: 1fr;
                min-height: auto;
                max-width: 520px;
            }
            .login-copy { display: none; }
            .login-panel { padding: 2.3rem 1.4rem 1.5rem; }
        }
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
            @endif
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">Logout</button>
            </form>
        @else
            <a href="{{ route('catalog') }}">Catalog</a>
            <a href="{{ route('track-order') }}">Track Order</a>
            <button type="button" data-login-open>Login</button>
        @endauth
    </div>
    <div class="nav-actions">
        <a href="{{ route('cart.index') }}" aria-label="Cart">
            <svg viewBox="0 0 24 24"><path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/></svg>
            @php($cartCount = collect(session('cart', []))->sum('quantity'))
            <span class="cart-count {{ $cartCount ? '' : 'is-empty' }}" data-cart-count>{{ $cartCount }}</span>
        </a>
        <button type="button" aria-label="Login" title="Login" data-login-open>
            <svg viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
        </button>
    </div>
</nav>

@guest
<div class="login-overlay {{ $errors->any() || session('status') ? 'is-open' : '' }}" id="loginModal" aria-hidden="{{ $errors->any() || session('status') ? 'false' : 'true' }}">
    <section class="login-popup" role="dialog" aria-modal="true" aria-labelledby="loginTitle">
        <button type="button" class="login-close" data-login-close aria-label="Close login">&times;</button>

        <div class="login-copy">
            <h2>Welcome back,<span>sweet soul.</span></h2>
            <p>Sign in to continue shopping small-batch treats, track your orders, or manage the SugarLoom dashboard.</p>
        </div>

        <div class="login-panel">
            <h2 id="loginTitle">Log in</h2>
            <p class="subtext">Use your SugarLoom account to continue.</p>

            @if (session('status'))
                <div class="login-status">{{ session('status') }}</div>
            @endif

            @if ($errors->any())
                <div class="login-errors">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="login-field">
                    <label for="modal-email">Email</label>
                    <input id="modal-email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username">
                    <span class="login-hint">Never shown to the public.</span>
                </div>

                <div class="login-field">
                    <label for="modal-password">Password</label>
                    <input id="modal-password" type="password" name="password" required autocomplete="current-password">
                </div>

                <div class="login-row">
                    <label class="login-remember" for="modal-remember">
                        <input id="modal-remember" type="checkbox" name="remember">
                        <span>Remember me</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="login-forgot" href="{{ route('password.request') }}">Forgot password?</a>
                    @endif
                </div>

                <button type="submit" class="login-submit">Log in</button>
            </form>

            @if (Route::has('register'))
                <p class="login-register">New here? <a href="{{ route('register') }}">Create an account</a></p>
            @endif
        </div>
    </section>
</div>
@endguest

<section class="hero">
    <div class="hero-text">
        <h1>
            Where sweet<br>
            dreams are<br>
            <span class="accent">woven!</span>
        </h1>
        <p>Indulge in our small-batch, handcrafted cookies baked daily with premium ingredients and a touch of artisanal magic.</p>
        <div class="hero-buttons">
            <a href="{{ route('catalog') }}" class="btn btn-primary">Shop Now</a>
            <a href="#" class="btn btn-white">Our Story</a>
        </div>
    </div>
    <div class="hero-image">
        <img src="{{ asset('images/cookies.png') }}" alt="Freshly baked cookies scattered">
    </div>
</section>

<section class="section best-sellers">
    <div class="section-header">
        <div>
            <h2>Best Sellers</h2>
            <p>The flavors that captured everyone's hearts.</p>
        </div>
        <a href="{{ route('catalog') }}" class="view-all">View All Catalog →</a>
    </div>

    <div class="products-grid">
        @foreach($bestSellers as $product)
        <div class="product-card">
            <img
                class="product-card-img"
                src="{{ $product->image ? asset($product->image) : asset('images/placeholder-cookie.png') }}"
                alt="{{ $product->name }}"
            >
            <div class="product-card-body">
                <div class="product-card-top">
                    <h3>{{ $product->name }}</h3>
                    <span class="product-price">₱{{ number_format($product->price, 0) }}</span>
                </div>
                <p class="product-desc">{{ $product->description }}</p>
                <button class="btn-add" data-product-id="{{ $product->id }}">Add to Box</button>
            </div>
        </div>
        @endforeach
    </div>
</section>

<section class="quiz-section">
    <div class="quiz-card">
        <img class="quiz-img" src="{{ asset('images/baking.png') }}" alt="Baking ingredients">
        <div class="quiz-content">
            <h2>Can't decide on a flavor?</h2>
            <p>Our flavor artisan can help you find your perfect match based on your taste profile. Whether you like it salty-sweet or intensely dark.</p>
            <button class="btn-quiz">
                <span>✦</span> Take the Flavor Quiz
            </button>
        </div>
    </div>
</section>

<section class="section testimonials">
    <div class="section-header">
        <h2>What Our Loomers Say</h2>
        <div class="divider"></div>
    </div>

    <div class="reviews-grid">
        @foreach($testimonials as $review)
        <div class="review-card">
            <div class="review-quote">"</div>
            <div class="stars">★★★★★</div>
            <p class="review-text">{{ $review->content }}</p>
            <div class="reviewer">
                <div class="reviewer-avatar">
                    @if($review->avatar)
                        <img src="{{ asset('storage/' . $review->avatar) }}" alt="{{ $review->name }}">
                    @else
                        {{ strtoupper(substr($review->name, 0, 1)) }}
                    @endif
                </div>
                <div>
                    <div class="reviewer-name">{{ $review->name }}</div>
                    <div class="reviewer-role">{{ $review->label }}</div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>

<footer>
    <div class="footer-logo">SugarLoom PH</div>
    <button class="footer-cart" aria-label="Cart">🛒</button>
</footer>

<div class="toast" id="toast"></div>

<script>
    // Use data attributes instead of inline onclick to avoid Blade/JS conflicts
    document.querySelectorAll('.btn-add[data-product-id]').forEach(function(btn) {
        btn.addEventListener('click', function() {
            addToCart(this.dataset.productId);
        });
    });

    function addToCart(productId) {
        fetch('/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ product_id: productId, quantity: 1 })
        })
        .then(function(res) { return res.json(); })
        .then(function(data) {
            updateCartCount(data.count || 0);
            showToast(data.message || 'Added to box! 🍪');
        })
        .catch(function() {
            showToast('Something went wrong. Please try again.');
        });
    }

    function showToast(message) {
        var toast = document.getElementById('toast');
        toast.textContent = message;
        toast.classList.add('show');
        setTimeout(function() { toast.classList.remove('show'); }, 2800);
    }

    function updateCartCount(count) {
        document.querySelectorAll('[data-cart-count]').forEach(function(badge) {
            badge.textContent = count;
            badge.classList.toggle('is-empty', count < 1);
        });
    }

    const loginModal = document.getElementById('loginModal');

    function openLoginModal() {
        if (!loginModal) return;
        loginModal.classList.add('is-open');
        loginModal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('modal-open');
        setTimeout(function() {
            document.getElementById('modal-email')?.focus();
        }, 50);
    }

    function closeLoginModal() {
        if (!loginModal) return;
        loginModal.classList.remove('is-open');
        loginModal.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('modal-open');
    }

    document.querySelectorAll('[data-login-open]').forEach(function(trigger) {
        trigger.addEventListener('click', openLoginModal);
    });

    document.querySelectorAll('[data-login-close]').forEach(function(trigger) {
        trigger.addEventListener('click', closeLoginModal);
    });

    loginModal?.addEventListener('click', function(event) {
        if (event.target === loginModal) {
            closeLoginModal();
        }
    });

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeLoginModal();
        }
    });

    if (loginModal?.classList.contains('is-open')) {
        document.body.classList.add('modal-open');
    }
</script>

</body>
</html>
