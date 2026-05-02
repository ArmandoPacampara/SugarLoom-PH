<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account | SugarLoom PH</title>
    <style>
        :root {
            --pink-nav:    #e06b87;
            --pink-pale:   #ffd7e1;
            --text-body:   #4a3d45;
            --dark:        #1a1018;
            --white:       #ffffff;
        }
        
        body { margin: 0; font-family: Arial, sans-serif; background: #fdf2f8; color: #111827; }
        
        /* Navbar Styles */
        .navbar { display: flex; align-items: center; justify-content: space-between; padding: 0 4rem; height: 70px; background: var(--pink-nav); }
        .logo { font-size: 1.1rem; font-weight: 900; color: white; text-decoration: none; }
        .nav-links { display: flex; gap: 2.5rem; align-items: center; position: absolute; left: 50%; transform: translateX(-50%); }
        .nav-links a, .nav-links button { color: white; text-decoration: none; background: none; border: none; font-size: 0.9rem; cursor: pointer; transition: opacity 0.2s; }
        .nav-links a:hover, .nav-links button:hover { opacity: 0.8; }
        
        .nav-actions { display: flex; gap: 0.8rem; }
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
        }
        .nav-actions > a:hover { background: rgba(255,255,255,0.2); }
        .nav-actions svg { width: 16px; height: 16px; fill: currentColor; }

        /* Page Layout Styles */
        .container { max-width: 1000px; margin: 40px auto; padding: 0 24px; }
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; }
        
        .card { background: white; padding: 30px; border-radius: 20px; box-shadow: 0 8px 20px rgba(0,0,0,0.05); }
        h1 { font-size: 28px; margin-bottom: 24px; }
        h3 { margin-top: 0; color: var(--text-body); border-bottom: 1px solid #f3eff1; padding-bottom: 10px; margin-bottom: 20px;}
        
        .form-group { margin-bottom: 16px; }
        label { display: block; font-size: 14px; font-weight: bold; color: var(--text-body); margin-bottom: 6px; }
        input[type="text"], input[type="email"] { width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 10px; box-sizing: border-box; }
        input:focus { outline: none; border-color: var(--pink-nav); box-shadow: 0 0 0 3px var(--pink-pale); }
        
        .btn-primary { background: #fb7185; color: white; border: none; padding: 10px 20px; border-radius: 999px; font-weight: bold; cursor: pointer; transition: opacity 0.2s; }
        .btn-primary:hover { opacity: 0.9; }
        .alert-success { background: #dcfce7; color: #16a34a; padding: 12px; border-radius: 10px; margin-bottom: 20px; font-size: 14px; font-weight: bold; }
        
        /* Order History Styles */
        .order-item { border: 1px solid #f3eff1; border-radius: 12px; padding: 16px; margin-bottom: 12px; }
        .order-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;}
        .order-id { font-weight: bold; color: var(--dark); }
        .order-price { font-weight: bold; color: var(--pink-nav); }
        .order-desc { font-size: 14px; color: gray; margin: 0; }
        .badge { padding: 4px 10px; border-radius: 999px; font-size: 11px; font-weight: bold; }
        .green { background: #dcfce7; color: #16a34a; }
        .blue { background: #dbeafe; color: #2563eb; }

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
        <a href="{{ auth()->check() ? route('profile.edit') : route('login') }}" aria-label="Account" title="Account">
            <svg viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
        </a>
    </div>
</nav>

<div class="container">
    <h1>My Account</h1>

    <!-- Success Message if Profile is Updated -->
    @if (session('status') === 'profile-updated')
        <div class="alert-success">Your profile has been updated successfully!</div>
    @endif

    <div class="grid-2">
        <!-- Account Details Form -->
        <div class="card">
            <h3>Profile Details</h3>
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('patch')

                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required>
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required>
                </div>

                <button type="submit" class="btn-primary" style="margin-top: 10px;">Save Changes</button>
            </form>
        </div>

        <!-- Order History (Visual Layout) -->
        <div class="card">
            <h3>Recent Purchases</h3>
            
            <div class="order-item">
                <div class="order-header">
                    <span class="order-id">Order #SL-8842</span>
                    <span class="badge green">Delivered</span>
                </div>
                <div class="order-header">
                    <p class="order-desc">1x Gourmet S'mores, 2x Red Velvet</p>
                    <span class="order-price">₱155.00</span>
                </div>
                <p class="order-desc" style="font-size: 12px; margin-top: 8px;">Placed on May 1, 2026</p>
            </div>

            <div class="order-item">
                <div class="order-header">
                    <span class="order-id">Order #SL-8109</span>
                    <span class="badge blue">Preparing</span>
                </div>
                <div class="order-header">
                    <p class="order-desc">1x Baked Sushi Tray</p>
                    <span class="order-price">₱650.00</span>
                </div>
                <p class="order-desc" style="font-size: 12px; margin-top: 8px;">Placed on April 28, 2026</p>
            </div>

        </div>
    </div>
</div>

</body>
</html>