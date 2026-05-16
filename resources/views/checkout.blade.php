@extends('layouts.app')

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

@section('title', 'Checkout - SugarLoom PH')

@section('styles')
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700;800&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
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
        }

        body {
            background: var(--blush);
            color: var(--ink);
            scroll-behavior: smooth;
        }

        /* ── ANIMATIONS ── */
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-4px); }
            75% { transform: translateX(4px); }
        }
        .cart-shake { animation: shake 0.4s ease-in-out; }

        .page {
            max-width: 1200px;
            margin: 0 auto;
            padding: 80px 40px 120px;
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

        input,
        select {
            width: 100%;
            border: 0;
            background: var(--panel-soft);
            min-height: 58px;
            padding: 0 16px;
            color: var(--ink);
            font: inherit;
            outline: 2px solid transparent;
        }

        input:focus,
        select:focus { outline-color: #f3a5b4; }

        select {
            appearance: auto;
            cursor: pointer;
        }

        .payment-title {
            margin-top: 48px;
            margin-bottom: 28px;
        }

        .payment-options {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
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
            transition: all 0.3s;
        }
        .payment-card:hover { transform: translateY(-3px); background: #fff; border-color: var(--pink-nav); }

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
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .confirm-button:hover:not(:disabled) { transform: translateY(-4px) scale(1.02); box-shadow: 0 15px 30px rgba(157, 79, 93, 0.35); }

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

        .promo-note {
            color: var(--muted);
            font-size: 13px;
            line-height: 1.45;
            margin-top: 10px;
        }

        .points-box {
            border: 1px solid #f0d8dd;
            background: #fff8fa;
            border-radius: 16px;
            padding: 14px;
            margin-top: 22px;
        }

        .points-box label,
        .reward-card label {
            margin-bottom: 8px;
        }

        .points-balance {
            color: var(--muted);
            font-size: 13px;
            line-height: 1.5;
            margin-bottom: 10px;
        }

        .reward-toggle {
            width: 100%;
            border: 0;
            min-height: 48px;
            border-radius: 999px;
            background: var(--rose);
            color: #fff;
            font: inherit;
            font-weight: 800;
            cursor: pointer;
            margin-bottom: 14px;
            box-shadow: 0 10px 20px rgba(157, 79, 93, 0.16);
        }

        .reward-panel {
            display: none;
            border: 1px solid #f0d8dd;
            background: #fff8fa;
            border-radius: 16px;
            padding: 14px;
            margin-bottom: 18px;
        }

        .reward-panel.is-open {
            display: block;
        }

        .reward-panel-title {
            font-size: 17px;
            font-weight: 800;
            color: var(--ink);
            margin-bottom: 6px;
        }

        .reward-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 12px;
            margin-top: 14px;
        }

        .reward-option input {
            display: none;
        }

        .reward-card {
            min-height: 76px;
            border: 2px solid #f0d8dd;
            background: #db1313;
            border-radius: 8px;
            padding: 12px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: border-color 0.2s, transform 0.2s;
        }

        .reward-card:hover {
            transform: translateY(-2px);
            border-color: #f3a5b4;
        }

        .reward-option input:checked + .reward-card {
            border-color: var(--rose);
            background: #fff7fa;
        }

        .reward-name {
            color: var(--ink);
            font-weight: 800;
            line-height: 1.25;
        }

        .reward-image {
            width: 52px;
            height: 52px;
            border-radius: 6px;
            object-fit: cover;
            flex: 0 0 52px;
            background: #f7e5e8;
        }

        .reward-details {
            min-width: 0;
        }

        .reward-meta {
            color: var(--muted);
            font-size: 12px;
            line-height: 1.4;
        }

        .reward-empty {
            color: var(--muted);
            font-size: 13px;
            line-height: 1.5;
            margin-top: 10px;
        }

        .override-box {
            background: #fff7ed;
            color: #9a3412;
            border-radius: 12px;
            padding: 12px 14px;
            margin-bottom: 18px;
            font-size: 13px;
            line-height: 1.5;
        }

        .delivery-status {
            min-height: 20px;
            margin-top: 12px;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.5;
        }

        .delivery-status.is-error {
            color: #8b2637;
            font-weight: 700;
        }

        .delivery-status.is-ready {
            color: #1f7a4d;
            font-weight: 800;
        }

        .discount-row {
            color: #1f7a4d;
            font-weight: 800;
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

        .summary-rewards {
            margin-bottom: 1.5rem;
            display: grid;
            gap: 1rem;
        }

        .reward-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 14px 18px;
            border-radius: 16px;
            background: rgb(252, 130, 130);
            color: rgb(255, 255, 255);
            text-decoration: none;
            font-weight: 700;
            border: none;
            transition: transform 0.2s ease;
        }

        .reward-button:hover {
            transform: translateY(-1px);
            background: #e11d48;
        }

        .reward-summary {
            padding: 16px 18px;
            border-radius: 16px;
            background: #fff4f9;
            border: 1px solid #f8d5e3;
            color: #602540;
            font-size: 0.95rem;
            line-height: 1.5;
        }

        .footer-links {
            display: flex;
            gap: 32px;
        }

        @media (max-width: 920px) {
            .checkout-layout { grid-template-columns: 1fr; }
            .summary { order: -1; }
        }

        @media (max-width: 640px) {
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
@endsection

@section('content')
<main class="page">
    <div class="steps" aria-label="Checkout progress" data-aos="fade-down">
        <div class="step active"><div class="step-bubble">1</div>Cart</div>
        <div class="step-line"></div>
        <div class="step"><div class="step-bubble">2</div>Shipping</div>
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
        <section class="empty-state" data-aos="zoom-in">
            <h1>Your cart is waiting for something sweet.</h1>
            <p>Add your favorite SugarLoom treats from the catalog, then come back here to check out.</p>
            <a href="{{ route('catalog') }}">Browse Catalog</a>
        </section>
    @else
        <div class="checkout-layout">
            <section data-aos="fade-right">
                @php($checkoutUser = auth()->user())
                <form method="POST" action="{{ route('checkout.process') }}" id="checkout-form">
                @csrf
                <input type="hidden" name="promo_code" value="{{ $totals['promo_code'] ?? $promoCode ?? '' }}">
                @if(session('address_validation_can_override'))
                    <input type="hidden" name="address_validation_override" value="1">
                    <div class="override-box">
                        Address validation could not confirm this location. Submit again to use the address as entered.
                    </div>
                @endif
                <h1>Shipping Information</h1>
                <div class="form-grid">
                    <div class="field full">
                        <label for="full_name">Full Name</label>
                        <input id="full_name" name="full_name" value="{{ old('full_name', $checkoutUser?->name) }}" placeholder="Eleanor Pasticceria" required>
                    </div>
                    <div class="field full">
                        <label for="email">Email Address</label>
                        <input id="email" type="email" name="email" value="{{ old('email', $checkoutUser?->email) }}" placeholder="eleanor@example.com" required>
                    </div>
                    <div class="field full">
                        <label for="phone">Mobile Number</label>
                        <input id="phone" name="phone" value="{{ old('phone', $checkoutUser?->phone) }}" placeholder="+63 917 888 2211" required>
                    </div>
                    <div class="field full">
                        <label for="shipping_address">Shipping Address</label>
                        <input id="shipping_address" name="shipping_address" value="{{ old('shipping_address', $checkoutUser?->shipping_address) }}" placeholder="123 Artisanal Lane, Flour District" required>
                    </div>
                    <div class="field">
                        <label for="city">City</label>
                        <select id="city" name="city" size="5" required>
                            <option value="">Select a Metro Manila city</option>
                            @foreach($metroManilaCities as $metroCity)
                                <option value="{{ $metroCity }}" @selected(old('city', $checkoutUser?->city) === $metroCity)>{{ $metroCity }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field">
                        <label for="postal_code">Postal Code</label>
                        <input id="postal_code" name="postal_code" value="{{ old('postal_code', $checkoutUser?->postal_code) }}" placeholder="1000" required>
                    </div>
                    <div class="field full">
                        <div class="delivery-status" id="delivery-status">
                            Delivery fee is estimated from Pinagbuhatan, Pasig City based on your selected city.
                        </div>
                    </div>
                </div>

                <h1 class="payment-title">Payment Method</h1>
                @auth
                    <div class="points-box">
                        <label for="redeem_points">Reward Points</label>
                        <p class="points-balance">
                            Balance: {{ number_format($rewardPointBalance) }} points.
                            @if($maxRedeemablePoints > 0)
                                You can redeem up to {{ number_format($maxRedeemablePoints) }} points on this order.
                            @else
                                Points can be redeemed after discounts leave an eligible subtotal.
                            @endif
                        </p>
                        <input
                            id="redeem_points"
                            type="number"
                            name="redeem_points"
                            min="0"
                            max="{{ $maxRedeemablePoints }}"
                            value="{{ old('redeem_points', 0) }}"
                            placeholder="0"
                        >
                    </div>
                @endauth
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
                </div>

                <button class="confirm-button" type="submit">Confirm Order</button>
                <p class="terms">By clicking "Confirm Order", you agree to our Terms of Service.</p>
                </form>
            </section>

            <aside class="summary" data-aos="fade-left">
                <div class="summary-rewards">
                    <a href="{{ route('cart.rewards') }}" class="reward-button">View Rewards</a>
                    <div class="reward-summary">
                        @auth
                            <p>Reward points balance: <strong>{{ number_format($rewardPointBalance) }}</strong> points.</p>
                            @if($rewardPointBalance >= $productRewardPointCost)
                                <p>You can redeem {{ number_format($productRewardPointCost) }} points for a reward product on checkout.</p>
                            @else
                                <p>You need <strong>{{ number_format($productRewardPointCost - $rewardPointBalance) }}</strong> more points to unlock the next reward.</p>
                            @endif
                        @else
                            <p>Log in to start earning points and redeem rewards on your SugarLoom order.</p>
                        @endauth
                    </div>
                </div>
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
                                <form id="remove-item-form-{{ $item['id'] }}" method="POST" action="{{ route('cart.remove', $item['id']) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="remove-button" type="button" aria-label="Remove {{ $item['name'] }}" onclick="confirmRemoveCartItem('{{ $item['id'] }}', '{{ addslashes($item['name']) }}')">x</button>
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
                @if(($totals['discount'] ?? 0) > 0)
                    <div class="total-row discount-row">
                        <span>{{ $totals['promo_code'] }} Discount</span>
                        <strong>-P{{ number_format($totals['discount'], 0) }}</strong>
                    </div>
                @endif
                <div class="total-row">
                    <span>Estimated Delivery</span>
                    <strong id="delivery-fee-display">P{{ number_format($totals['delivery_fee'], 0) }}</strong>
                </div>
                <div class="total-row grand-total">
                    <span>Total</span>
                    <span id="grand-total-display">P{{ number_format($totals['total'], 0) }}</span>
                </div>
                <form method="POST" action="{{ route('cart.promo') }}">
                    @csrf
                    <div class="promo">
                        <input name="promo_code" value="{{ old('promo_code', $promoCode ?? '') }}" placeholder="Promo Code">
                        <button type="submit">Apply</button>
                    </div>
                </form>
                <p class="promo-note">Sample voucher: <strong>SWEET10</strong> gives 10% off your subtotal. Clear the field and apply again to remove it.</p>
            </aside>
        </div>
    @endif
</main>
@endsection

@section('scripts')
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
AOS.init({
    once: true,
    duration: 800,
    easing: 'ease-out-cubic'
});

const checkoutForm = document.getElementById('checkout-form');
const statusBox = document.getElementById('delivery-status');
const deliveryFeeDisplay = document.getElementById('delivery-fee-display');
const grandTotalDisplay = document.getElementById('grand-total-display');
const citySelect = document.getElementById('city');
const deliveryFees = @json(config('sugarloom.delivery_fees.metro_manila', []));
const defaultDeliveryFee = {{ (float) config('sugarloom.delivery_fees.default_fee', 160) }};
const baseTotal = {{ (float) ($totals['total'] - $totals['delivery_fee']) }};

function formatPeso(value) {
    return `P${Math.round(value).toLocaleString()}`;
}

function setDeliveryStatus(message) {
    statusBox.textContent = message;
    statusBox.className = 'delivery-status';
}

function updateEstimatedDelivery() {
    const city = citySelect?.value || '';
    const fee = city ? Number(deliveryFees[city] ?? defaultDeliveryFee) : 0;

    deliveryFeeDisplay.textContent = formatPeso(fee);
    grandTotalDisplay.textContent = formatPeso(baseTotal + fee);

    if (city) {
        setDeliveryStatus(`Estimated delivery from Pinagbuhatan, Pasig City to ${city}: ${formatPeso(fee)}.`);
    } else {
        setDeliveryStatus('Select a Metro Manila city to see the estimated delivery fee.');
    }
}

citySelect?.addEventListener('change', updateEstimatedDelivery);
updateEstimatedDelivery();

function confirmRemoveCartItem(id, name) {
    openConfirmationModal(
        'Remove Item',
        `Are you sure you want to remove "${name}" from your cart?`,
        function() {
            document.getElementById('remove-item-form-' + id).submit();
        }
    );
}
</script>
@endsection
