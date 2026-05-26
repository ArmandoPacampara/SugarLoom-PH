<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password | SugarLoom PH</title>

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

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #fdf2f8;
            color: #111827;
        }

        .navbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 4rem;
            height: 70px;
            background: var(--pink-nav);
        }

        .logo {
            font-size: 1.1rem;
            font-weight: 900;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .navbar-logo {
            height: 40px;
            width: auto;
            object-fit: contain;
        }

        .container {
            max-width: 520px;
            margin: 60px auto;
            padding: 0 24px;
        }

        .card {
            background: white;
            padding: 32px;
            border-radius: 20px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.05);
        }

        h2 {
            font-size: 26px;
            margin-top: 0;
            margin-bottom: 10px;
            text-align: center;
            color: var(--pink-deep);
        }

        .description {
            text-align: center;
            color: var(--text-muted);
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 24px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            font-size: 14px;
            font-weight: bold;
            color: var(--text-body);
            margin-bottom: 6px;
        }

        input[type="email"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            box-sizing: border-box;
            font-size: 14px;
        }

        input:focus {
            outline: none;
            border-color: var(--pink-nav);
            box-shadow: 0 0 0 3px var(--pink-pale);
        }

        .btn-primary {
            background: #fb7185;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 999px;
            font-weight: bold;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
            transition: opacity 0.2s;
        }

        .btn-primary:hover {
            opacity: 0.9;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-error {
            color: #dc2626;
            font-size: 13px;
            margin-top: 6px;
        }

        .text-center {
            text-align: center;
            margin-top: 18px;
            font-size: 14px;
        }

        .text-center a {
            color: var(--pink-deep);
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body>

<nav class="navbar">
    <a href="{{ route('home') }}" class="logo">
        <img src="{{ asset('images/SugarLoom_Logo.png') }}" alt="SugarLoom Logo" class="navbar-logo">
        SugarLoom PH
    </a>
</nav>

<div class="container">
    <div class="card">

        <h2>Forgot Password</h2>

        <div class="description">
            Forgot your password? No problem. Enter your email address and we’ll send you a password reset link.
        </div>

        @if (session('status'))
            <div class="alert-success">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email Address</label>

                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    placeholder="juan@example.com"
                >

                @error('email')
                    <div class="alert-error">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn-primary">
                Email Password Reset Link
            </button>

            <div class="text-center">
                <a href="{{ route('login') }}">Back to Login</a>
            </div>
        </form>

    </div>
</div>

</body>
</html>