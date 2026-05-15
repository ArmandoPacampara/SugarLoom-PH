<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SugarLoom PH – Where Sweet Dreams Are Woven')</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,700&family=DM+Sans:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --pink-nav:    #e06b87;
            --pink-bg-base:#fdf1f4;
            --pink-btn:    #ce5a7a; 
            --text-dark:   #2b1b24; 
            --text-accent: #835372; 
            --text-body:   #665560; 
            --cream:       #fdf6f0;
            --white:       #ffffff;
            --radius-card: 20px;
            --shadow-card: 0 8px 32px rgba(201,75,118,0.10);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--cream);
            position: relative;
            color: var(--text-body);
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* ── ENHANCED BACKGROUND ── */
        body::before {
            content: "";
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background-image: 
                linear-gradient(rgba(253, 241, 244, 0.8) 1px, transparent 1px),
                linear-gradient(90deg, rgba(253, 241, 244, 0.8) 1px, transparent 1px);
            background-size: 40px 40px;
            z-index: -1;
            pointer-events: none;
        }

        .bg-decor {
            position: fixed;
            width: 100vw;
            height: 100vh;
            top: 0;
            left: 0;
            z-index: -2;
            overflow: hidden;
            pointer-events: none;
        }

        .blob {
            position: absolute;
            background: var(--pink-pale);
            filter: blur(80px);
            border-radius: 50%;
            opacity: 0.4;
            animation: move 25s infinite alternate;
        }

        .blob-1 { width: 400px; height: 400px; top: -100px; right: -100px; background: #ffe4e9; }
        .blob-2 { width: 350px; height: 350px; bottom: 10%; left: -50px; background: #fff0f3; animation-delay: -5s; }
        .blob-3 { width: 300px; height: 300px; top: 40%; right: 15%; background: #fdf1f4; animation-delay: -10s; }

        @keyframes move {
            from { transform: translate(0, 0) scale(1); }
            to   { transform: translate(40px, 60px) scale(1.1); }
        }

        main { flex: 1; position: relative; z-index: 1; }

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
            background: #e06b87;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .logo {
            font-size: 1.1rem;
            font-weight: 900;
            color: white;
            text-decoration: none;
            letter-spacing: 0;
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
            width: 38px;
            height: 38px;
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
            text-shadow: 0 1px 2px rgba(43,27,36,0.45);
        }

        .cart-count.is-empty { display: none; }

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
            transition: gap 0.2s;
        }

        .view-all:hover { gap: 0.55rem; }

        /* ── PRODUCT CARDS ── */
        .products-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem; }

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

        body.modal-open { overflow: hidden; }

        .product-modal {
            position: fixed;
            inset: 0;
            z-index: 10000;
            display: grid;
            place-items: center;
            padding: 1.5rem;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.24s ease;
        }

        .product-modal.is-open {
            opacity: 1;
            pointer-events: auto;
        }

        .product-modal__overlay {
            position: absolute;
            inset: 0;
            background: rgba(43, 27, 36, 0.48);
            backdrop-filter: blur(6px);
        }

        .product-modal__dialog {
            position: relative;
            width: min(920px, 100%);
            max-height: min(720px, calc(100vh - 2rem));
            display: grid;
            grid-template-columns: minmax(280px, 0.9fr) 1fr;
            background: var(--white);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 26px 80px rgba(43, 27, 36, 0.28);
            transform: translateY(18px) scale(0.98);
            transition: transform 0.24s ease;
        }

        .product-modal.is-open .product-modal__dialog {
            transform: translateY(0) scale(1);
        }

        .product-modal__close {
            position: absolute;
            top: 0.9rem;
            right: 0.9rem;
            z-index: 2;
            width: 38px;
            height: 38px;
            border: 0;
            border-radius: 50%;
            background: rgba(255,255,255,0.88);
            color: var(--text-dark);
            font-size: 1.6rem;
            line-height: 1;
            cursor: pointer;
            box-shadow: 0 8px 22px rgba(43, 27, 36, 0.14);
        }

        .product-modal__media {
            position: relative;
            min-height: 420px;
            background: #fdf1f4;
        }

        .product-modal__media img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .product-modal__price {
            position: absolute;
            left: 1rem;
            bottom: 1rem;
            background: var(--white);
            color: var(--pink-btn);
            border-radius: 999px;
            padding: 0.45rem 0.9rem;
            font-weight: 800;
            box-shadow: 0 8px 22px rgba(43, 27, 36, 0.14);
        }

        .product-modal__content {
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .product-modal__eyebrow {
            color: var(--pink-btn);
            font-size: 0.76rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 0.6rem;
        }

        .product-modal__content h2 {
            font-size: 2.25rem;
            line-height: 1.08;
            margin-bottom: 1rem;
        }

        .product-modal__description {
            color: var(--text-body);
            line-height: 1.75;
            font-size: 0.96rem;
            margin-bottom: 1.2rem;
        }

        .product-modal__stock {
            color: #15803d;
            font-weight: 700;
            margin-bottom: 1.2rem;
        }

        .product-modal__quantity {
            width: 164px;
            height: 46px;
            display: grid;
            grid-template-columns: 46px 1fr 46px;
            border: 1px solid #f0e1e5;
            border-radius: 999px;
            overflow: hidden;
            margin-bottom: 1rem;
            background: #fff8fa;
        }

        .product-modal__quantity button,
        .product-modal__quantity input {
            border: 0;
            background: transparent;
            color: var(--text-dark);
            font: inherit;
            text-align: center;
        }

        .product-modal__quantity button {
            cursor: pointer;
            font-size: 1.3rem;
            font-weight: 700;
        }

        .product-modal__quantity input {
            min-width: 0;
            font-weight: 800;
            -moz-appearance: textfield;
            appearance: textfield;
        }

        .product-modal__quantity input::-webkit-outer-spin-button,
        .product-modal__quantity input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .product-modal__add {
            border: 0;
            border-radius: 999px;
            background: var(--pink-btn);
            color: white;
            padding: 0.95rem 1.4rem;
            font-size: 0.95rem;
            font-weight: 700;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
            box-shadow: 0 10px 24px rgba(206, 90, 122, 0.28);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .product-modal__add:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 14px 30px rgba(206, 90, 122, 0.38);
        }

        .product-modal__add:disabled {
            cursor: wait;
            opacity: 0.75;
        }

        @media (max-width: 760px) {
            .product-modal {
                align-items: end;
                padding: 0;
            }

            .product-modal__dialog {
                width: 100%;
                max-height: 92vh;
                grid-template-columns: 1fr;
                border-radius: 20px 20px 0 0;
                overflow-y: auto;
            }

            .product-modal__media {
                min-height: 240px;
                height: 34vh;
            }

            .product-modal__content {
                padding: 1.6rem;
            }

            .product-modal__content h2 {
                font-size: 1.7rem;
            }
        }

        /* ── FOOTER ── */
        footer {
            background: #e06b87;
            padding: 2rem 4rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .footer-logo {
            font-size: 1.25rem;
            font-weight: 900;
            color: var(--text-dark);
            text-decoration: none;
        }

        .footer-cart {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: rgba(255,255,255,0.2);
            border: 1px solid rgba(255,255,255,0.4);
            color: white;
            display: grid;
            place-items: center;
            font-size: 1.1rem;
            cursor: pointer;
        }

        @include('partials.navbar-styles')
        @include('partials.login-modal-styles')

    </style>

    {{-- Page-specific styles go here, outside the global <style> tag --}}
    @yield('styles')

</head>
<body class="antialiased">

<div class="bg-decor">
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>
    <div class="blob blob-3"></div>
</div>

@include('partials.navbar')
@include('partials.login-modal')
@include('partials.cookie-consent')

<main>
    @yield('content')
</main>

@unless(request()->is('admin*'))
<footer>
    <a href="/" class="footer-logo">SugarLoom PH</a>
    <button class="footer-cart" aria-label="Cart">🛒</button>
</footer>
@endunless

<div class="toast" id="toast"></div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.btn-add[data-product-id]:not([data-product-modal])').forEach(function(btn) {
            btn.addEventListener('click', function() {
                addToCart(this.dataset.productId);
            });
        });
    });

    function addToCart(productId, quantity, options = {}) {
        quantity = quantity || 1;

        return fetch('/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ product_id: productId, quantity: quantity })
        })
        .then(function(res) {
            return res.json().then(function(data) {
                data.success = res.ok && data.success !== false;
                return data;
            });
        })
        .then(function(data) {
            if (data.success) {
                updateCartCount(data.count || 0);
                showToast(data.message || 'Added to cart.');

                if (options.redirectToCart) {
                    window.location.href = '/cart';
                }
            } else {
                showToast(data.message || 'Unable to add that item.');
            }

            return data;
        })
        .catch(function() {
            showToast('Something went wrong. Please try again.');
            throw new Error('Cart request failed');
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
</script>

@include('partials.login-modal-script')
@if(! request()->is('admin*') && (! auth()->check() || auth()->user()->isCustomer()))
<script
  src="https://www.tuqlas.com/chatbot.js"
  data-key="tq_live_79b4eda62537a5c11e8f96e96142e08ae0e9265b"
  data-api="https://www.tuqlas.com"
  defer
></script>
@endif
@yield('scripts')

</body>
</html>
