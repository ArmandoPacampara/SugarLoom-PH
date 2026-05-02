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
            background: #e06b87;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .logo { font-size: 1.1rem; font-weight: 900; color: white; text-decoration: none; letter-spacing: 0; }

        .nav-links { position: absolute; left: 50%; transform: translateX(-50%); display: flex; gap: 2.5rem; }
        .nav-links a { color: var(--white); text-decoration: none; font-size: 0.9rem; font-weight: 400; transition: opacity 0.2s; }
        .nav-links form { margin: 0; }
        .nav-links button { background: transparent; border: 0; color: var(--white); cursor: pointer; font: inherit; padding: 0; }
        .nav-links a:hover, .nav-links button:hover { opacity: 0.8; }

        .nav-actions { display: flex; gap: 0.8rem; }
        .nav-actions > button,
        .nav-actions > a,
        .nav-actions > span {
            width: 38px; height: 38px; border-radius: 50%; border: 1px solid rgba(255,255,255,0.5);
            background: transparent; color: var(--text-dark); cursor: pointer; display: grid;
            place-items: center; transition: background 0.2s; padding: 0; position: relative;
        }
        .nav-actions > button:hover,
        .nav-actions > a:hover,
        .nav-actions > span:hover { background: rgba(255,255,255,0.2); }
        .nav-actions svg { width: 16px; height: 16px; fill: currentColor; }
        .cart-count {
            position: absolute; top: -9px; right: -7px; color: white;
            font-size: 0.72rem; font-weight: 800; line-height: 1;
            text-shadow: 0 1px 2px rgba(43, 27, 36, 0.45);
        }
        .cart-count.is-empty { display: none; }

        /* ── SECTION COMMONS ── */
        .section { padding: 5rem 4rem; }
        .section-header { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 3rem; }
        .section-header h2 { font-size: 2.5rem; font-weight: 800; }
        .section-header p { font-size: 1rem; color: var(--text-body); margin-top: 0.5rem; font-weight: 300; }
        
        .view-all { font-size: 0.95rem; color: var(--pink-btn); font-weight: 600; text-decoration: none; display: flex; align-items: center; gap: 0.3rem; transition: gap 0.2s; }
        .view-all:hover { gap: 0.55rem; }

        /* ── PRODUCT CARDS ── */
        .products-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem; }
        .product-card {
            border: 1px solid #f4e9ec; border-radius: var(--radius-card); overflow: hidden;
            background: var(--white); box-shadow: var(--shadow-card); transition: transform 0.25s, box-shadow 0.25s;
        }
        .product-card:hover { transform: translateY(-4px); box-shadow: 0 16px 40px rgba(201,75,118,0.15); }
        .product-card-img { width: 100%; height: 240px; object-fit: cover; display: block; background: #fdf1f4; }
        .product-card-body { padding: 1.5rem; }
        .product-card-top { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.75rem; }
        .product-card-top h3 { font-size: 1.25rem; font-weight: 700; line-height: 1.2; }
        .product-price { font-weight: 700; font-size: 1.1rem; color: var(--pink-btn); }
        .product-desc { font-size: 0.9rem; font-weight: 300; line-height: 1.6; margin-bottom: 1.5rem; }

        .btn-add {
            width: 100%; padding: 0.8rem; border-radius: 999px; border: 1.5px solid #f0e1e5;
            background: white; color: var(--text-dark); font-size: 0.95rem; font-weight: 600;
            cursor: pointer; transition: all 0.2s; font-family: 'Poppins', sans-serif;
        }
        .btn-add:hover { background: var(--pink-btn); color: white; border-color: var(--pink-btn); }

        /* ── TOAST ── */
        .toast {
            position: fixed; bottom: 2rem; left: 50%; transform: translateX(-50%) translateY(80px);
            background: var(--text-dark); color: white; padding: 0.8rem 1.8rem; border-radius: 999px;
            font-size: 0.95rem; font-weight: 500; z-index: 9999; transition: transform 0.3s ease; pointer-events: none;
        }
        .toast.show { transform: translateX(-50%) translateY(0); }

        /* ── FOOTER ── */
        footer { background: #e06b87; padding: 2rem 4rem; display: flex; align-items: center; justify-content: space-between; }
        .footer-logo { font-size: 1.25rem; font-weight: 900; color: var(--text-dark); text-decoration: none; }
        .footer-cart { width: 44px; height: 44px; border-radius: 50%; background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.4); color: white; display: grid; place-items: center; font-size: 1.1rem; cursor: pointer; }

        /* Provide a spot for page-specific styles */
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
            <a href="{{ route('login') }}">Login</a>
        @endauth
    </div>
    <div class="nav-actions">
        <a href="{{ route('cart.index') }}" aria-label="Cart">
            <svg viewBox="0 0 24 24"><path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/></svg>
            @php($cartCount = collect(session('cart', []))->sum('quantity'))
            <span class="cart-count {{ $cartCount ? '' : 'is-empty' }}" data-cart-count>{{ $cartCount }}</span>
        </a>
        <a href="{{ auth()->check() ? route('profile.edit') : route('login') }}" aria-label="Account" title="Account">
            <svg viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
        </a>
    </div>
</nav>

<main>
    @yield('content')
</main>

<footer>
    <a href="/" class="footer-logo">SugarLoom PH</a>
    <button class="footer-cart" aria-label="Cart">🛒</button>
</footer>

<div class="toast" id="toast"></div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // We run this on load so it binds to any buttons that get loaded in
        document.querySelectorAll('.btn-add[data-product-id]').forEach(function(btn) {
            btn.addEventListener('click', function() {
                addToCart(this.dataset.productId);
            });
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
        .catch(function() { showToast('Something went wrong. Please try again.'); });
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

@yield('scripts')
</body>
</html>
