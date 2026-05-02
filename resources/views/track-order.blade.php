<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Order | SugarLoom PH</title>
    <style>
        :root {
            --pink-deep:   #d8547b; 
            --pink-nav:    #e06b87;
            --pink-light:  #f8bac9;
            --pink-pale:   #ffd7e1;
            --cream:       #fffcfc; 
            --dark:        #1a1018;
            --text-body:   #4a3d45;
            --white:       #ffffff;
            --gray-btn:    #f3eff1;
        }

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

        .cart-count.is-empty { display: none; }
        
        body { margin: 0; font-family: Arial, sans-serif; background: #fdf2f8; color: #111827; }
        
        /* Navbar Styles */
        .navbar { display: flex; align-items: center; justify-content: space-between; padding: 0 4rem; height: 70px; background: var(--pink-nav); }
        .logo { font-size: 1.1rem; font-weight: 900; color: white; text-decoration: none; }
        .nav-links { display: flex; gap: 2.5rem; align-items: center; position: absolute; left: 50%; transform: translateX(-50%); }
        .nav-links a { color: white; text-decoration: none; font-size: 0.9rem; transition: opacity 0.2s; }
        .nav-links form { margin: 0; }
        .nav-links button { background: transparent; border: 0; color: white; cursor: pointer; font: inherit; padding: 0; transition: opacity 0.2s; }
        .nav-links a:hover, .nav-links button:hover { opacity: 0.8; }
        .nav-links a.active { color: white; }
        
        .nav-actions { display: flex; gap: 0.8rem; }
        .nav-actions > button,
        .nav-actions > a {
            width: 38px; height: 38px;
            border-radius: 50%;
            border: 1px solid rgba(255,255,255,0.5);
            background: transparent;
            color: var(--dark);
            cursor: pointer;
            display: grid;
            place-items: center;
            transition: background 0.2s;
            text-decoration: none;
            padding: 0;
            position: relative;
        }
        .nav-actions > button:hover,
        .nav-actions > a:hover { background: rgba(255,255,255,0.2); }
        .nav-actions svg { width: 16px; height: 16px; fill: currentColor; }
        .login-btn { background: transparent; border: 0; font: inherit; }

        /* Page Layout Styles */
        .container { max-width: 600px; margin: 60px auto; padding: 0 24px; }
        .card { background: white; padding: 40px; border-radius: 20px; box-shadow: 0 8px 20px rgba(0,0,0,0.05); text-align: center; }
        
        h1 { font-size: 28px; margin-top: 0; color: var(--pink-deep); margin-bottom: 10px; }
        p.subtitle { color: gray; margin-bottom: 30px; font-size: 15px; }

        .search-form { display: flex; gap: 10px; justify-content: center; margin-bottom: 20px; }
        input[type="text"] { width: 65%; padding: 14px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 16px; transition: border-color 0.2s; }
        input:focus { outline: none; border-color: var(--pink-nav); }
        
        .btn-primary { background: #fb7185; color: white; border: none; padding: 0 24px; border-radius: 10px; font-weight: bold; cursor: pointer; transition: opacity 0.2s; font-size: 16px; }
        .btn-primary:hover { opacity: 0.9; }

        hr { border: none; border-top: 1px solid #f3eff1; margin: 30px 0; }

        /* Timeline Styles */
        .tracking-result { text-align: left; }
        .tracking-result h3 { margin-top: 0; margin-bottom: 24px; color: var(--dark); }
        
        .timeline { display: flex; flex-direction: column; gap: 24px; position: relative; }
        .timeline::before {
            content: ''; position: absolute; left: 11px; top: 10px; bottom: 10px; width: 2px; background: #e5e7eb; z-index: 0;
        }

        .timeline-step { display: flex; align-items: flex-start; gap: 20px; position: relative; z-index: 1; opacity: 0.5; }
        .timeline-step.active { opacity: 1; }
        
        .dot { width: 24px; height: 24px; border-radius: 50%; background: white; border: 3px solid #e5e7eb; display: flex; align-items: center; justify-content: center; box-sizing: border-box; }
        .timeline-step.active .dot { border-color: var(--pink-nav); background: var(--pink-pale); }
        
        .info { display: flex; flex-direction: column; padding-top: 2px; }
        .info strong { font-size: 16px; color: var(--dark); }
        .info .time { font-size: 13px; color: gray; margin-top: 4px; }
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
    <div class="card">
        <h1>Track Your Order</h1>
        <p class="subtitle">Enter your order ID below to check the current delivery status.</p>

        <!-- Tracking Input Form -->
        <form class="search-form" method="GET" action="{{ route('track-order') }}">
            <input type="text" name="tracking_number" value="{{ request('tracking_number') }}" placeholder="e.g. SL-123456-PH" required>
            <button type="submit" class="btn-primary">Track</button>
        </form>

        <!-- Progress Display (Only shows if a tracking number is submitted) -->
        @if(request('tracking_number'))
            <hr>
            <div class="tracking-result">
                <h3>Status for: <span style="color: var(--pink-nav);">{{ request('tracking_number') }}</span></h3>
                
                <div class="timeline">
                    <!-- Step 1 -->
                    <div class="timeline-step active">
                        <div class="dot"></div>
                        <div class="info">
                            <strong>Order Confirmed</strong>
                            <span class="time">Payment verified. We've received your order!</span>
                        </div>
                    </div>
                    
                    <!-- Step 2 -->
                    <div class="timeline-step active">
                        <div class="dot"></div>
                        <div class="info">
                            <strong>Preparing Sweets</strong>
                            <span class="time">Our bakers are currently preparing your items.</span>
                        </div>
                    </div>
                    
                    <!-- Step 3 -->
                    <div class="timeline-step">
                        <div class="dot"></div>
                        <div class="info">
                            <strong>Out for Delivery</strong>
                            <span class="time">Pending rider pickup.</span>
                        </div>
                    </div>

                    <!-- Step 4 -->
                    <div class="timeline-step">
                        <div class="dot"></div>
                        <div class="info">
                            <strong>Delivered</strong>
                            <span class="time">Pending.</span>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

</body>
</html>