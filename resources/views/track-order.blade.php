@php
    $order = session('latest_order', [
        'number' => 'SL-89234-PH',
        'customer' => [
            'full_name' => 'Sofia Vergara',
            'shipping_address' => '123 Amethyst Lane, Serendra Two',
            'city' => 'Bonifacio Global City, Taguig',
            'postal_code' => '1634',
            'phone' => '+63 917 888 2211',
        ],
        'items' => [
            ['name' => 'Truffle Cocoa Cake', 'quantity' => 1, 'price' => 1250, 'image' => null],
            ['name' => 'Rose Macarons (Set)', 'quantity' => 2, 'price' => 240, 'image' => null],
        ],
        'totals' => ['total' => 1730],
    ]);

    $fallbacks = ['images/baking.png', 'images/Macaroons.png', 'images/cookies4.jpeg'];
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Order - SugarLoom PH</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --rose: #9d4f5d;
            --pink: #ff9daf;
            --blush: #fff7f7;
            --soft: #f5eaea;
            --ink: #251f22;
            --muted: #75676c;
            --brown: #815f57;
            --pink-nav: #e06b87;
            --white: #ffffff;
            --text-dark: #1a1018;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: 'DM Sans', sans-serif;
            background: var(--blush);
            color: var(--ink);
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
        .nav-links a.active { color: var(--white); border-bottom: 0; padding-bottom: 0; }

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

        .page {
            max-width: 1230px;
            margin: 0 auto;
            padding: 48px 32px 80px;
        }

        .status-kicker {
            color: var(--rose);
            text-transform: uppercase;
            letter-spacing: .12em;
            font-size: 12px;
            font-weight: 800;
            margin-bottom: 8px;
        }

        h1 {
            margin: 0;
            font-size: clamp(40px, 6vw, 58px);
            line-height: 1;
            letter-spacing: 0;
        }

        .eta {
            margin-top: 16px;
            color: #5d5356;
            font-size: 18px;
        }

        .eta strong { color: var(--rose); }

        .layout {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 390px;
            gap: 32px;
            margin-top: 52px;
        }

        .card {
            background: #fff;
            border-radius: 28px;
            padding: 30px 32px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .04);
        }

        .progress-card { padding-top: 36px; }

        .progress {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            position: relative;
            margin-bottom: 46px;
        }

        .progress::before {
            content: "";
            position: absolute;
            top: 20px;
            left: 4%;
            right: 4%;
            height: 4px;
            background: #eadfe1;
        }

        .progress::after {
            content: "";
            position: absolute;
            top: 20px;
            left: 4%;
            width: 38%;
            height: 4px;
            background: var(--pink);
        }

        .step {
            position: relative;
            z-index: 1;
            text-align: center;
            color: #a99b9f;
            font-size: 13px;
            font-weight: 800;
        }

        .dot {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin: 0 auto 10px;
            display: grid;
            place-items: center;
            background: #f1ebec;
            color: #b6aaae;
        }

        .step.done,
        .step.current { color: var(--rose); }

        .step.done .dot,
        .step.current .dot {
            background: var(--rose);
            color: #fff;
        }

        .message {
            display: grid;
            grid-template-columns: 120px 1fr;
            gap: 24px;
            align-items: center;
            background: #fbefef;
            border-radius: 14px;
            padding: 24px;
        }

        .message img {
            width: 96px;
            height: 96px;
            border-radius: 50%;
            object-fit: cover;
        }

        .message h2 {
            margin: 0 0 6px;
            font-size: 22px;
        }

        .message p {
            margin: 0;
            color: #5f5356;
            line-height: 1.45;
        }

        .timeline {
            background: #f0e4e5;
            margin-top: 32px;
        }

        .timeline h2,
        .side-title {
            margin: 0 0 26px;
            font-size: 20px;
        }

        .event {
            display: grid;
            grid-template-columns: 16px 1fr;
            gap: 10px;
            margin: 22px 0;
        }

        .event-dot {
            width: 8px;
            height: 8px;
            margin-top: 7px;
            border-radius: 50%;
            background: #d6c4c8;
        }

        .event:first-of-type .event-dot { background: var(--rose); }

        .event strong { display: block; }
        .event span { color: #6d6265; font-size: 12px; }

        .sidebar {
            display: grid;
            gap: 32px;
            align-content: start;
        }

        .item {
            display: grid;
            grid-template-columns: 48px 1fr auto;
            gap: 12px;
            align-items: center;
            margin-bottom: 20px;
        }

        .item img {
            width: 48px;
            height: 48px;
            object-fit: cover;
            border-radius: 12px;
        }

        .item strong { display: block; font-size: 15px; }
        .item span { color: #6d6265; font-size: 13px; }
        .item-price { color: var(--brown); font-weight: 800; }

        .summary-total {
            border-top: 1px solid #f0e5e5;
            padding-top: 24px;
            margin-top: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: 800;
        }

        .summary-total span:last-child {
            color: var(--rose);
            font-size: 26px;
        }

        .details p {
            margin: 8px 0;
            color: #574d50;
            line-height: 1.45;
        }

        .details strong { display: block; margin-bottom: 8px; }

        .support {
            background: var(--brown);
            color: #fff;
            text-align: center;
            padding: 28px;
        }

        .support p {
            color: #f7dddd;
            font-size: 13px;
        }

        .support a {
            color: #ffb3c0;
            font-weight: 800;
        }

        .notice {
            margin-top: 24px;
            background: #f0fff4;
            color: #22633a;
            border-radius: 12px;
            padding: 14px 16px;
        }

        .footer {
            background: #f4f4f4;
            padding: 42px 48px;
            display: flex;
            justify-content: space-between;
            color: #81787b;
            font-size: 14px;
        }

        .footer strong { color: #a30f3b; font-size: 18px; }
        .footer-links { display: flex; gap: 32px; }

        @media (max-width: 900px) {
            .layout { grid-template-columns: 1fr; }
            .nav-links { display: none; }
        }

        @media (max-width: 620px) {
            .navbar { padding: 0 2rem; }
            .page { padding: 34px 18px 56px; }
            .message { grid-template-columns: 1fr; }
            .footer { display: grid; gap: 20px; padding: 30px 20px; }
            .footer-links { flex-wrap: wrap; gap: 18px; }
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
                    <a href="{{ route('track-order') }}" class="active">Track Order</a>
                @endif
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            @else
                <a href="{{ route('catalog') }}">Catalog</a>
                <a href="{{ route('track-order') }}" class="active">Track Order</a>
                <a href="{{ route('login') }}">Login</a>
            @endauth
        </div>
        <div class="nav-actions">
            <a href="{{ route('cart.index') }}" aria-label="Cart">
                <svg viewBox="0 0 24 24"><path d="M7 18c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.6-1.35 2.44A2 2 0 0 0 7 17h12v-2H7.42l1.1-2h7.45c.75 0 1.41-.41 1.75-1.03L21 6H5.21l-.94-2H1zm16 16c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/></svg>
            </a>
            <a href="{{ route('login') }}" aria-label="Login" title="Login">
                <svg viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
            </a>
        </div>
    </nav>

    <main class="page">
        <div class="status-kicker">Order in Progress</div>
        <h1>#{{ $order['number'] }}</h1>
        <div class="eta">Expected delivery: Today at <strong>{{ now()->addMinutes(75)->format('g:i A') }}</strong></div>

        @if(session('status'))
            <div class="notice">{{ session('status') }}</div>
        @endif

        <div class="layout">
            <section>
                <div class="card progress-card">
                    <div class="progress">
                        <div class="step done"><div class="dot">✓</div>Confirmed</div>
                        <div class="step current"><div class="dot">◒</div>Baking</div>
                        <div class="step"><div class="dot">□</div>Ready</div>
                        <div class="step"><div class="dot">▱</div>Delivery</div>
                    </div>
                    <div class="message">
                        <img src="{{ asset('images/baking.png') }}" alt="Freshly baked bread">
                        <div>
                            <h2>Your order is in the oven!</h2>
                            <p>Our bakers are currently preparing your artisanal selection with care. We expect to have it ready for dispatch in 45 minutes.</p>
                        </div>
                    </div>
                </div>

                <div class="card timeline">
                    <h2>Order Timeline</h2>
                    <div class="event">
                        <span class="event-dot"></span>
                        <div><strong>Started Baking</strong><span>Today, {{ now()->format('g:i A') }} · Artisan Kitchen Unit 4</span></div>
                    </div>
                    <div class="event">
                        <span class="event-dot"></span>
                        <div><strong>Quality Check Passed</strong><span>Today, {{ now()->subMinutes(15)->format('g:i A') }} · Ingredients Verified</span></div>
                    </div>
                    <div class="event">
                        <span class="event-dot"></span>
                        <div><strong>Order Confirmed</strong><span>Today, {{ now()->subMinutes(30)->format('g:i A') }} · Transaction {{ $order['number'] }}</span></div>
                    </div>
                </div>
            </section>

            <aside class="sidebar">
                <div class="card">
                    <h2 class="side-title">Items Summary</h2>
                    @foreach($order['items'] as $index => $item)
                        <div class="item">
                            <img src="{{ asset($fallbacks[$index] ?? 'images/cookies1.jpeg') }}" alt="{{ $item['name'] }}">
                            <div>
                                <strong>{{ $item['name'] }}</strong>
                                <span>Qty: {{ $item['quantity'] }}</span>
                            </div>
                            <div class="item-price">P{{ number_format($item['price'] * $item['quantity'], 0) }}</div>
                        </div>
                    @endforeach
                    <div class="summary-total">
                        <span>Total Amount</span>
                        <span>P{{ number_format($order['totals']['total'], 0) }}</span>
                    </div>
                </div>

                <div class="card details">
                    <h2 class="side-title">Delivery Details</h2>
                    <strong>{{ $order['customer']['full_name'] }}</strong>
                    <p>{{ $order['customer']['shipping_address'] }}</p>
                    <p>{{ $order['customer']['city'] }}, {{ $order['customer']['postal_code'] }}</p>
                    <p>{{ $order['customer']['phone'] }}</p>
                </div>

                <div class="card support">
                    <h2 class="side-title">Need assistance?</h2>
                    <p>Our concierge team is available 24/7 to help with your artisanal order.</p>
                    <a href="#">Contact Support →</a>
                </div>
            </aside>
        </div>
    </main>

    <footer class="footer">
        <div><strong>SugarLoom PH</strong><br>© 2024 SugarLoom PH. Baked with artisanal care.</div>
        <div class="footer-links">
            <a href="#">Facebook</a>
            <a href="#">Instagram</a>
            <a href="#">Contact Us</a>
            <a href="#">Privacy Policy</a>
        </div>
    </footer>
</body>
</html>
