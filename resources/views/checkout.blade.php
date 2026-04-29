@php
    $fallbackImages = [
        'red velvet' => 'images/Red Velvet Cookie.png',
        'chocolate chip' => 'images/cookies.png',
        'brownies' => 'images/Brownies.png',
        's\'mores' => 'images/S\'mores Cookie.png',
        'gourmet s\'mores' => 'images/smores.jpg',
        'mocha' => 'images/Mocha Cookie.png',
        'strawberry' => 'images/Strawberry Cookie.png',
        'matcha' => 'images/Matcha Cookie.png',
    ];

    $imageFor = function ($item) use ($fallbackImages) {
        if (! empty($item['image']) && file_exists(public_path($item['image']))) {
            return asset($item['image']);
        }

        $key = strtolower($item['name']);

        return asset($fallbackImages[$key] ?? 'images/cookies1.jpeg');
    };
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Checkout - SugarLoom PH</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --rose: #9d4f5d;
            --rose-soft: #ff9daf;
            --blush: #fff7f7;
            --panel: #ffffff;
            --panel-soft: #fbeeee;
            --ink: #251f22;
            --muted: #75676c;
            --line: #eadfe1;
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

        .nav-links a:hover { opacity: 0.8; }
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

        .icon-link {
            position: relative;
        }

        .nav-actions svg { width: 16px; height: 16px; fill: currentColor; }

        .cart-count {
            position: absolute;
            top: -9px;
            right: -7px;
            color: #fff;
            font-size: 0.72rem;
            font-weight: 800;
            line-height: 1;
            text-shadow: 0 1px 2px rgba(37, 31, 34, 0.45);
        }

        .cart-count.is-empty { display: none; }

        .page {
            max-width: 1090px;
            margin: 0 auto;
            padding: 46px 28px 80px;
        }

        .steps {
            display: grid;
            grid-template-columns: 48px minmax(70px, 250px) 48px minmax(70px, 250px) 48px;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-bottom: 56px;
        }

        .step {
            text-align: center;
            color: var(--muted);
            font-size: 13px;
            font-weight: 700;
        }

        .step-bubble {
            width: 40px;
            height: 40px;
            margin: 0 auto 8px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            background: #eee6e6;
            color: #5b5050;
            font-weight: 800;
        }

        .step.active .step-bubble {
            background: var(--rose);
            color: #fff;
        }

        .step-line {
            height: 4px;
            background: #eadfe1;
            margin-bottom: 25px;
        }

        .step-line.active { background: var(--rose-soft); }

        .checkout-layout {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 424px;
            gap: 48px;
            align-items: start;
        }

        h1 {
            font-size: 28px;
            margin: 0 0 30px;
            letter-spacing: 0;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 22px 24px;
        }

        .field.full { grid-column: 1 / -1; }

        label {
            display: block;
            font-size: 14px;
            font-weight: 700;
            color: #504449;
            margin-bottom: 10px;
        }

        input {
            width: 100%;
            border: 0;
            background: var(--panel-soft);
            min-height: 58px;
            padding: 0 16px;
            color: var(--ink);
            font: inherit;
            outline: 2px solid transparent;
        }

        input:focus { outline-color: #f3a5b4; }

        .payment-title {
            margin-top: 48px;
            margin-bottom: 28px;
        }

        .payment-options {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
        }

        .payment-option input { display: none; }

        .payment-card {
            height: 96px;
            border: 2px solid transparent;
            border-radius: 30px;
            background: var(--panel-soft);
            display: grid;
            place-items: center;
            gap: 8px;
            font-weight: 700;
            color: #4d3739;
            cursor: pointer;
        }

        .payment-card svg {
            width: 24px;
            height: 24px;
            stroke: currentColor;
            stroke-width: 2;
            fill: none;
        }

        .payment-option input:checked + .payment-card {
            background: #fff;
            border-color: var(--rose);
        }

        .confirm-button {
            width: 100%;
            border: 0;
            margin-top: 78px;
            min-height: 68px;
            border-radius: 999px;
            color: #fff;
            font-size: 18px;
            font-weight: 800;
            font-family: inherit;
            cursor: pointer;
            background: linear-gradient(90deg, var(--rose), #ff9daf);
            box-shadow: 0 12px 24px rgba(157, 79, 93, 0.2);
        }

        .confirm-button:disabled {
            background: #d9cfd1;
            cursor: not-allowed;
            box-shadow: none;
        }

        .terms {
            margin: 18px 0 0;
            text-align: center;
            color: #5f5356;
            font-size: 12px;
        }

        .summary {
            background: var(--panel);
            border-radius: 28px;
            padding: 34px 32px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .summary-title {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 24px;
            font-weight: 800;
            margin-bottom: 28px;
        }

        .summary-title svg {
            width: 24px;
            height: 24px;
            stroke: var(--rose);
            stroke-width: 2;
            fill: none;
        }

        .cart-item {
            display: grid;
            grid-template-columns: 80px minmax(0, 1fr) auto;
            gap: 16px;
            align-items: center;
            margin-bottom: 20px;
        }

        .cart-item img {
            width: 80px;
            height: 80px;
            border-radius: 6px;
            object-fit: cover;
        }

        .item-name {
            font-size: 16px;
            font-weight: 800;
            margin-bottom: 4px;
        }

        .item-desc {
            font-size: 12px;
            color: var(--muted);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 160px;
        }

        .item-price {
            color: var(--rose);
            font-weight: 800;
            align-self: start;
            padding-top: 4px;
        }

        .qty-row {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 9px;
        }

        .qty-form {
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .qty-button,
        .remove-button {
            width: 24px;
            height: 24px;
            border: 0;
            border-radius: 50%;
            background: #f0dddd;
            color: #8a676d;
            font-weight: 800;
            cursor: pointer;
            display: grid;
            place-items: center;
        }

        .remove-button {
            background: transparent;
            color: #9b858a;
            font-size: 18px;
        }

        .quantity {
            min-width: 16px;
            text-align: center;
            font-weight: 700;
        }

        .summary-divider {
            border: 0;
            border-top: 1px dashed #e2c3c8;
            margin: 30px 0;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 16px 0;
            color: #4f4548;
        }

        .total-row strong {
            color: var(--ink);
        }

        .grand-total {
            margin-top: 34px;
            font-size: 24px;
            font-weight: 800;
        }

        .grand-total span:last-child {
            color: var(--rose);
        }

        .promo {
            display: grid;
            grid-template-columns: 1fr 94px;
            gap: 8px;
            margin-top: 38px;
        }

        .promo input { min-height: 45px; }

        .promo button {
            border: 0;
            background: var(--brown);
            color: #fff;
            font: inherit;
            font-weight: 800;
            cursor: pointer;
        }

        .empty-state {
            background: #fff;
            border-radius: 18px;
            padding: 34px;
            text-align: center;
            color: var(--muted);
        }

        .empty-state a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-top: 18px;
            min-height: 44px;
            padding: 0 20px;
            border-radius: 999px;
            background: var(--rose);
            color: #fff;
            font-weight: 800;
        }

        .notice,
        .errors {
            margin-bottom: 22px;
            border-radius: 12px;
            padding: 14px 16px;
            font-size: 14px;
        }

        .notice {
            background: #f0fff4;
            color: #22633a;
        }

        .errors {
            background: #fff0f0;
            color: #8b2637;
        }

        .footer {
            background: #f4f4f4;
            padding: 42px;
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
            margin-bottom: 10px;
        }

        .footer-links {
            display: flex;
            gap: 32px;
        }

        @media (max-width: 920px) {
            .checkout-layout { grid-template-columns: 1fr; }
            .summary { order: -1; }
            .nav-links { display: none; }
        }

        @media (max-width: 640px) {
            .navbar { padding: 0 2rem; }
            .logo { font-size: 1.1rem; }
            .page { padding: 30px 18px 56px; }
            .steps {
                grid-template-columns: 40px 1fr 40px 1fr 40px;
                gap: 8px;
            }
            .form-grid,
            .payment-options {
                grid-template-columns: 1fr;
            }
            .cart-item {
                grid-template-columns: 64px 1fr;
            }
            .cart-item img {
                width: 64px;
                height: 64px;
            }
            .item-price {
                grid-column: 2;
                padding-top: 0;
            }
            .confirm-button { margin-top: 42px; }
            .footer {
                display: grid;
                gap: 24px;
                padding: 30px 20px;
            }
            .footer-links {
                flex-wrap: wrap;
                gap: 18px;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="{{ route('home') }}" class="logo">SugarLoom PH</a>
        <div class="nav-links">
            <a href="{{ route('catalog') }}">Catalog</a>
            <a href="{{ route('track-order') }}">Track Order</a>
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </div>
        <div class="nav-actions">
            <a class="icon-link active" href="{{ route('cart.index') }}" aria-label="Cart">
                <svg viewBox="0 0 24 24"><path d="M7 18c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.6-1.35 2.44A2 2 0 0 0 7 17h12v-2H7.42l1.1-2h7.45c.75 0 1.41-.41 1.75-1.03L21 6H5.21l-.94-2H1zm16 16c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/></svg>
                <span class="cart-count {{ $cartItems->sum('quantity') ? '' : 'is-empty' }}" data-cart-count>{{ $cartItems->sum('quantity') }}</span>
            </a>
            <span class="icon-link" aria-label="Account">
                <svg viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
            </span>
        </div>
    </nav>

    <main class="page">
        <div class="steps" aria-label="Checkout progress">
            <div class="step active"><div class="step-bubble">1</div>Cart</div>
            <div class="step-line active"></div>
            <div class="step active"><div class="step-bubble">2</div>Shipping</div>
            <div class="step-line"></div>
            <div class="step"><div class="step-bubble">3</div>Payment</div>
        </div>

        @if (session('status'))
            <div class="notice">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div class="errors">
                {{ $errors->first() }}
            </div>
        @endif

        @if($cartItems->isEmpty())
            <section class="empty-state">
                <h1>Your cart is waiting for something sweet.</h1>
                <p>Add your favorite SugarLoom treats from the catalog, then come back here to check out.</p>
                <a href="{{ route('catalog') }}">Browse Catalog</a>
            </section>
        @else
            <div class="checkout-layout">
                <section>
                    <form method="POST" action="{{ route('checkout.process') }}" id="checkout-form">
                    @csrf
                    <h1>Shipping Information</h1>
                    <div class="form-grid">
                        <div class="field full">
                            <label for="full_name">Full Name</label>
                            <input id="full_name" name="full_name" value="{{ old('full_name') }}" placeholder="Eleanor Pasticceria" required>
                        </div>
                        <div class="field full">
                            <label for="email">Email Address</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="eleanor@example.com" required>
                        </div>
                        <div class="field full">
                            <label for="phone">Mobile Number</label>
                            <input id="phone" name="phone" value="{{ old('phone') }}" placeholder="+63 917 888 2211" required>
                        </div>
                        <div class="field full">
                            <label for="shipping_address">Shipping Address</label>
                            <input id="shipping_address" name="shipping_address" value="{{ old('shipping_address') }}" placeholder="123 Artisanal Lane, Flour District" required>
                        </div>
                        <div class="field">
                            <label for="city">City</label>
                            <input id="city" name="city" value="{{ old('city') }}" placeholder="Manila" required>
                        </div>
                        <div class="field">
                            <label for="postal_code">Postal Code</label>
                            <input id="postal_code" name="postal_code" value="{{ old('postal_code') }}" placeholder="1000" required>
                        </div>
                    </div>

                    <h1 class="payment-title">Payment Method</h1>
                    <div class="payment-options">
                        <label class="payment-option">
                            <input type="radio" name="payment_method" value="card" @checked(old('payment_method', 'card') === 'card')>
                            <span class="payment-card">
                                <svg viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="14" rx="2"></rect><path d="M3 10h18"></path></svg>
                                Card
                            </span>
                        </label>
                        <label class="payment-option">
                            <input type="radio" name="payment_method" value="gcash" @checked(old('payment_method') === 'gcash')>
                            <span class="payment-card">
                                <svg viewBox="0 0 24 24"><rect x="4" y="4" width="16" height="16" rx="2"></rect><path d="M8 12h8M12 8v8"></path></svg>
                                GCash
                            </span>
                        </label>
                        <label class="payment-option">
                            <input type="radio" name="payment_method" value="cod" @checked(old('payment_method') === 'cod')>
                            <span class="payment-card">
                                <svg viewBox="0 0 24 24"><rect x="3" y="7" width="18" height="10" rx="2"></rect><circle cx="12" cy="12" r="2"></circle><path d="M7 7V5h10v2"></path></svg>
                                COD
                            </span>
                        </label>
                    </div>

                    <button class="confirm-button" type="submit">Confirm Order</button>
                    <p class="terms">By clicking "Confirm Order", you agree to our Terms of Service.</p>
                    </form>
                </section>

                <aside class="summary">
                    <div class="summary-title">
                        <svg viewBox="0 0 24 24"><path d="M6 8h12l-1 12H7L6 8Z"></path><path d="M9 8a3 3 0 0 1 6 0"></path></svg>
                        Order Summary
                    </div>

                    @foreach($cartItems as $item)
                        <div class="cart-item">
                            <img src="{{ $imageFor($item) }}" alt="{{ $item['name'] }}">
                            <div>
                                <div class="item-name">{{ $item['name'] }}</div>
                                <div class="item-desc">{{ $item['description'] }}</div>
                                <div class="qty-row">
                                    <form class="qty-form" method="POST" action="{{ route('cart.update', $item['id']) }}">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="quantity" value="{{ max(1, $item['quantity'] - 1) }}">
                                        <button class="qty-button" type="submit" @disabled($item['quantity'] <= 1)>-</button>
                                    </form>
                                    <span class="quantity">{{ $item['quantity'] }}</span>
                                    <form class="qty-form" method="POST" action="{{ route('cart.update', $item['id']) }}">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="quantity" value="{{ $item['quantity'] + 1 }}">
                                        <button class="qty-button" type="submit">+</button>
                                    </form>
                                    <form method="POST" action="{{ route('cart.remove', $item['id']) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="remove-button" type="submit" aria-label="Remove {{ $item['name'] }}">x</button>
                                    </form>
                                </div>
                            </div>
                            <div class="item-price">P{{ number_format($item['price'] * $item['quantity'], 0) }}</div>
                        </div>
                    @endforeach

                    <hr class="summary-divider">

                    <div class="total-row">
                        <span>Subtotal</span>
                        <strong>P{{ number_format($totals['subtotal'], 0) }}</strong>
                    </div>
                    <div class="total-row">
                        <span>Delivery Fee</span>
                        <strong>P{{ number_format($totals['delivery_fee'], 0) }}</strong>
                    </div>
                    <div class="total-row">
                        <span>Tax</span>
                        <strong>P{{ number_format($totals['tax'], 0) }}</strong>
                    </div>
                    <div class="total-row grand-total">
                        <span>Total</span>
                        <span>P{{ number_format($totals['total'], 0) }}</span>
                    </div>
                    <div class="promo">
                        <input form="checkout-form" name="promo_code" value="{{ old('promo_code') }}" placeholder="Promo Code">
                        <button type="button">Apply</button>
                    </div>
                </aside>
            </div>
        @endif
    </main>

    <footer class="footer">
        <div>
            <strong>SugarLoom PH</strong>
            <span>© 2024 SugarLoom PH. Baked with artisanal care.</span>
        </div>
        <div class="footer-links">
            <a href="#">Facebook</a>
            <a href="#">Instagram</a>
            <a href="#">Contact Us</a>
            <a href="#">Privacy Policy</a>
        </div>
    </footer>
</body>
</html>
