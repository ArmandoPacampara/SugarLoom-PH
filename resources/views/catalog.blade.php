<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Catalog – SugarLoom PH</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --pink-deep:   #d8547b; 
            --pink-nav: #e06b87;
            --pink-light:  #f8bac9;
            --pink-pale:   #ffd7e1;
            --cream:       #fffcfc; 
            --dark:        #1a1018;
            --text-body:   #4a3d45;
            --text-muted:  #8a7080;
            --white:       #ffffff;
            --gray-btn:    #f3eff1;
            --radius-card: 24px;
            --radius-pill: 999px;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--cream);
            color: var(--dark);
            overflow-x: hidden;
        }

        /* ── NAVBAR ──────────────────────────────────── */

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
            font-family: 'DM Sans', sans-serif;
            font-size: 1.1rem;
            font-weight: 900;
            color: white;
            letter-spacing: 0;
            text-decoration: none;
        }

        .logo-icon {
            width: 32px; height: 32px;
            background: var(--white);
            border-radius: 50%;
            display: grid;
            place-items: center;
            color: var(--pink-deep);
            font-size: 1rem;
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
        .nav-links a.active { color: var(--white); }

        .nav-actions {
            display: flex;
            gap: 0.8rem;
        }

        .nav-actions > button,
        .nav-actions > a,
        .nav-actions > span {
            width: 38px; height: 38px;
            border-radius: 50%;
            border: 1px solid rgba(255,255,255,0.5);
            background: transparent;
            color: var(--dark);
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
            text-shadow: 0 1px 2px rgba(26, 16, 24, 0.45);
        }

        .cart-count.is-empty { display: none; }

        .login-btn { background: transparent; border: 0; font: inherit; }

        /* ── PAGE HEADER ─────────────────────────────── */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2.5rem 2rem;
        }

        .page-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 2rem;
            margin-bottom: 2.5rem;
        }

        .page-header-left h1 {
            font-family: 'DM Sans', sans-serif;
            font-weight: 700;
            font-size: 2.5rem;
            color: var(--dark);
            line-height: 1.2;
            letter-spacing: -0.03em;
        }

        .page-header-left p {
            font-size: 0.95rem;
            color: var(--text-muted);
            margin-top: 0.5rem;
            max-width: 360px;
            line-height: 1.5;
        }

        /* Baker's Choice Card */
        .bakers-choice {
            background: var(--pink-deep);
            border-radius: 20px;
            padding: 1.5rem;
            color: white;
            min-width: 380px;
            position: relative;
        }

        .bakers-choice-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 0.2rem;
        }

        .bakers-choice h3 {
            font-size: 1.1rem;
            font-weight: 700;
        }

        .bakers-price {
            font-size: 1.2rem;
            font-weight: 700;
        }

        .bakers-choice p {
            font-size: 0.85rem;
            opacity: 0.9;
            margin-bottom: 1.2rem;
            max-width: 250px;
        }

        .btn-quick-add {
            width: 100%;
            padding: 0.7rem;
            border-radius: var(--radius-pill);
            border: none;
            background: white;
            color: var(--pink-deep);
            font-size: 0.9rem;
            font-weight: 700;
            cursor: pointer;
        }

        /* ── FEATURED TOP PICK ───────────────────────── */
        .top-pick-card {
            display: flex;
            border-radius: var(--radius-card);
            overflow: hidden;
            background: var(--pink-pale);
            min-height: 260px;
            margin-bottom: 3rem;
        }

        .top-pick-content {
            flex: 1;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .top-pick-badge {
            background: rgba(216, 84, 123, 0.15);
            color: var(--pink-deep);
            border-radius: var(--radius-pill);
            padding: 0.3rem 0.8rem;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            width: fit-content;
            margin-bottom: 1rem;
            letter-spacing: 0.05em;
        }

        .top-pick-content h2 {
            font-family: 'DM Sans', sans-serif;
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--dark);
            line-height: 1.1;
            margin-bottom: 0.5rem;
        }

        .top-pick-content p {
            font-size: 0.9rem;
            color: var(--text-body);
            line-height: 1.5;
            max-width: 300px;
            margin-bottom: 1.5rem;
        }

        .top-pick-actions {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .top-pick-price {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--dark);
        }

        .btn-cart {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--pink-deep);
            color: white;
            border: none;
            border-radius: var(--radius-pill);
            padding: 0.6rem 1.5rem;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
        }

        .top-pick-img-wrap {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem 1.5rem 1.5rem 0; 
            background: #8b5a33; /* You can remove this background if your actual images look better without it! */
        }

        .top-pick-img {
            width: 100%; 
            height: 100%;
            max-height: 240px; 
            object-fit: cover; 
            object-position: center;
            border-radius: 16px; 
            box-shadow: 0 8px 24px rgba(0,0,0,0.12); 
        }

        /* ── PRODUCTS SECTION ────────────────────────── */
        .products-section-header {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .products-section-header h2 {
            font-size: 1.25rem;
            font-weight: 700;
        }

        .filter-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: var(--pink-deep);
            border-radius: var(--radius-pill);
            padding: 0.5rem;
            margin-bottom: 2rem;
        }

        .filter-tabs {
            display: flex;
            gap: 0.5rem;
        }

        .filter-tab {
            border: none;
            border-radius: var(--radius-pill);
            padding: 0.5rem 1.2rem;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            background: transparent;
            color: white;
            font-family: 'DM Sans', sans-serif;
            transition: 0.2s;
        }

        .filter-tab.active {
            background: white;
            color: var(--pink-deep);
        }

        .sort-label {
            font-size: 0.75rem;
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding-right: 1rem;
            opacity: 0.9;
        }

        /* Product Grid */
        .catalog-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
        }

        .catalog-card {
            background: var(--white);
            border-radius: var(--radius-card);
            padding: 0.8rem;
            transition: transform 0.2s;
        }

        .catalog-card:hover { transform: translateY(-4px); }

        .catalog-img-wrap {
            position: relative;
            height: 280px;
            border-radius: 16px;
            overflow: hidden;
            margin-bottom: 1rem;
        }

        .catalog-img-wrap img {
            width: 100%; height: 100%;
            object-fit: cover;
        }

        .catalog-price-badge {
            position: absolute;
            top: 12px; right: 12px;
            background: white;
            border-radius: var(--radius-pill);
            padding: 0.3rem 0.6rem;
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--dark);
        }

        .catalog-card-body {
            padding: 0 0.5rem;
        }

        .catalog-name-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.3rem;
        }

        .catalog-name {
            font-size: 1.05rem;
            font-weight: 700;
        }

        .catalog-rating {
            font-size: 0.8rem;
            font-weight: 700;
            color: #f4a623;
        }

        .catalog-desc {
            font-size: 0.8rem;
            color: var(--text-muted);
            line-height: 1.5;
            margin-bottom: 1.2rem;
            height: 40px; 
            overflow: hidden;
        }

        .btn-add-catalog {
            width: 100%;
            padding: 0.7rem;
            border-radius: var(--radius-pill);
            border: none;
            background: var(--gray-btn);
            color: var(--dark);
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-add-catalog:hover { background: #e5e0e3; }

        .toast {
            position: fixed;
            right: 2rem;
            bottom: 2rem;
            transform: translateY(90px);
            opacity: 0;
            background: var(--dark);
            color: white;
            padding: 0.9rem 1.2rem;
            border-radius: 999px;
            box-shadow: 0 14px 34px rgba(26, 16, 24, 0.22);
            font-size: 0.92rem;
            font-weight: 700;
            z-index: 9999;
            pointer-events: none;
            transition: transform 0.25s ease, opacity 0.25s ease;
        }

        .toast.show {
            transform: translateY(0);
            opacity: 1;
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
            <svg viewBox="0 0 24 24"><path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/></svg>
            @php($cartCount = collect(session('cart', []))->sum('quantity'))
            <span class="cart-count {{ $cartCount ? '' : 'is-empty' }}" data-cart-count>{{ $cartCount }}</span>
        </a>
        @auth
            <a href="{{ route('profile.edit') }}" aria-label="Account" title="Account">
                <svg viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
            </a>
        @else
            <a href="{{ route('login') }}" aria-label="Account" title="Account">
                <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/></svg>
            </a>
        @endauth
    </div>
</nav>


<div class="container">
    <div class="page-header">
        <div class="page-header-left">
            <h1>Artisanal Confections</h1>
            <p>Hand-crafted batches, premium ingredients, and a touch of sweetness delivered from our oven to your home.</p>
        </div>

        @if($bakersChoice)
        <div class="bakers-choice">
            <div class="bakers-choice-top">
                <h3>Baker's Choice: {{ $bakersChoice->name }}</h3>
                <div class="bakers-price">₱{{ number_format($bakersChoice->price, 0) }}</div>
            </div>
            <p>{{ $bakersChoice->short_description ?? $bakersChoice->description }}</p>
            <button class="btn-quick-add" data-id="{{ $bakersChoice->id }}">Quick Add</button>
        </div>
        @endif
    </div>

    @if($topPick)
    <section class="top-pick-card">
        <div class="top-pick-content">
            <span class="top-pick-badge">Top Pick</span>
            <h2>{{ $topPick->name }}</h2>
            <p>{{ $topPick->description }}</p>
            <div class="top-pick-actions">
                <span class="top-pick-price">₱{{ number_format($topPick->price, 0) }}</span>
                <button class="btn-cart" data-id="{{ $topPick->id }}">🛒 Add to Cart</button>
            </div>
        </div>
        <div class="top-pick-img-wrap">
            <img class="top-pick-img" src="{{ $topPick->image ? asset($topPick->image) : asset('images/placeholder-cookie.png') }}" alt="{{ $topPick->name }}">
        </div>
    </section>
    @endif

    <section class="products-section">
        <div class="products-section-header">
            <h2>✨ Recommended for You</h2>
        </div>

        <div class="filter-bar">
            <div class="filter-tabs">
                <button class="filter-tab active" data-filter="all" onclick="filterProducts(this, 'all')">All Flavors</button>
                <button class="filter-tab" data-filter="sweet" onclick="filterProducts(this, 'sweet')">Sweet</button>
                <button class="filter-tab" data-filter="savory" onclick="filterProducts(this, 'savory')">Savory</button>
                <button class="filter-tab" data-filter="nutty" onclick="filterProducts(this, 'nutty')">Nutty</button>
            </div>
            <span class="sort-label">✎ Sorted by Popularity</span>
        </div>

        <div class="catalog-grid" id="productsGrid">
            @isset($products)
            @foreach($products as $product)
            <div class="catalog-card" data-category="{{ $product->category }}">
                <div class="catalog-img-wrap">
                    <img src="{{ $product->image ? asset($product->image) : asset('images/placeholder-cookie.png') }}" alt="{{ $product->name }}">
                    <span class="catalog-price-badge">₱{{ number_format($product->price, 0) }}</span>
                </div>
                <div class="catalog-card-body">
                    <div class="catalog-name-row">
                        <span class="catalog-name">{{ $product->name }}</span>
                        @if($product->rating)
                        <span class="catalog-rating">★ {{ number_format($product->rating, 1) }}</span>
                        @endif
                    </div>
                    <p class="catalog-desc">{{ $product->description }}</p>
                    <button class="btn-add-catalog" data-id="{{ $product->id }}">+ Add to Cart</button>
                </div>
            </div>
            @endforeach
            @endisset
        </div>
    </section>
</div>

<div class="toast" id="toast" role="status" aria-live="polite"></div>

<script>
function filterProducts(btn, filter) {
    // Update active tab
    document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
    btn.classList.add('active');

    // Filter cards
    document.querySelectorAll('.catalog-card').forEach(card => {
        const match = filter === 'all' || card.dataset.category === filter;
        card.style.display = match ? '' : 'none';
    });
}

function addToCart(productId) {
    fetch('/cart/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
        },
        body: JSON.stringify({ product_id: productId, quantity: 1 })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            updateCartCount(data.count || 0);
            showToast('Added to cart.');
        }
    })
    .catch(() => showToast('Something went wrong. Please try again.'));
}

document.querySelectorAll('[data-id]').forEach(button => {
    button.addEventListener('click', () => addToCart(button.dataset.id));
});

let toastTimer;
function showToast(message) {
    const toast = document.getElementById('toast');
    toast.textContent = message;
    toast.classList.add('show');
    clearTimeout(toastTimer);
    toastTimer = setTimeout(() => toast.classList.remove('show'), 2600);
}

function updateCartCount(count) {
    document.querySelectorAll('[data-cart-count]').forEach(badge => {
        badge.textContent = count;
        badge.classList.toggle('is-empty', count < 1);
    });
}
</script>

</body>
</html>
