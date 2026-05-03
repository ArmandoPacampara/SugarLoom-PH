<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | SugarLoom PH</title>
    <style>
        :root {
            --pink-deep:   #d8547b; 
            --pink-nav:    #e06b87;
            --pink-light:  #f8bac9;
            --pink-pale:   #ffd7e1;
            --cream:       #fffcfc; 
            --dark:        #1a1018;
            --text-body:   #4a3d45;
            --text-muted:  #8a7080;
            --white:       #ffffff;
        }

        body { margin: 0; font-family: Arial, sans-serif; background: #fdf2f8; color: #111827; }
        .navbar { display: flex; align-items: center; justify-content: space-between; padding: 0 4rem; height: 70px; background: var(--pink-nav); }
        .logo { font-size: 1.1rem; font-weight: 900; color: white; text-decoration: none; }
        
        .container { max-width: 620px; margin: 44px auto; padding: 0 24px; }
        .card { background: white; padding: 30px; border-radius: 20px; box-shadow: 0 8px 20px rgba(0,0,0,0.05); }
        
        h2 { font-size: 24px; margin-top: 0; text-align: center; color: var(--pink-deep); }
        
        .form-group { margin-bottom: 16px; }
        label { display: block; font-size: 14px; font-weight: bold; color: var(--text-body); margin-bottom: 6px; }
        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 10px; box-sizing: border-box; font-size: 14px;
        }
        input:focus { outline: none; border-color: var(--pink-nav); box-shadow: 0 0 0 3px var(--pink-pale); }

        .btn-primary {
            background: #fb7185; color: white; border: none; padding: 12px; border-radius: 999px; font-weight: bold; cursor: pointer; width: 100%; font-size: 16px; transition: opacity 0.2s;
        }
        .btn-primary:hover { opacity: 0.9; }
        
        .text-center { text-align: center; margin-top: 16px; font-size: 14px; }
        .text-center a { color: var(--pink-deep); text-decoration: none; font-weight: bold; }
        
        .alert-error { background: #fee2e2; color: #b91c1c; padding: 12px; border-radius: 10px; margin-bottom: 20px; font-size: 14px; }
    </style>
</head>
<body>

<nav class="navbar">
    <a href="{{ route('home') }}" class="logo">SugarLoom PH</a>
</nav>

<div class="container">
    <div class="card">
        <h2>Create an Account</h2>

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="alert-error">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <label for="name">Full Name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus placeholder="Juan Dela Cruz">
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required placeholder="juan@example.com">
            </div>

            <div class="form-group">
                <label for="phone">Mobile Number</label>
                <input id="phone" type="text" name="phone" value="{{ old('phone') }}" required placeholder="+63 917 888 2211">
            </div>

            <div class="form-group">
                <label for="shipping_address">Shipping Address</label>
                <input id="shipping_address" type="text" name="shipping_address" value="{{ old('shipping_address') }}" required placeholder="123 Artisanal Lane, Flour District">
            </div>

            <div class="form-group">
                <label for="city">City</label>
                <input id="city" type="text" name="city" value="{{ old('city') }}" required placeholder="Manila">
            </div>

            <div class="form-group">
                <label for="postal_code">Postal Code</label>
                <input id="postal_code" type="text" name="postal_code" value="{{ old('postal_code') }}" required placeholder="1000">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required placeholder="••••••••">
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required placeholder="••••••••">
            </div>

            <button type="submit" class="btn-primary">Register Now</button>

            <div class="text-center">
                Already have an account? <a href="{{ route('login') }}">Log in here</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>
