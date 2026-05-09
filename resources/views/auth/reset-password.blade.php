<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | SugarLoom PH</title>

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

        input[type="email"],
        input[type="password"] {
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
            margin-top: 8px;
        }

        .btn-primary:hover {
            opacity: 0.9;
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
    <a href="{{ route('home') }}" class="logo">SugarLoom PH</a>
</nav>

<div class="container">
    <div class="card">

        <h2>Reset Password</h2>

        <div class="description">
            Create a new secure password for your SugarLoom PH account.
        </div>

        <form method="POST" action="{{ route('password.store') }}">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <div class="form-group">
                <label for="email">Email Address</label>

                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email', $request->email) }}"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="juan@example.com"
                >

                @error('email')
                    <div class="alert-error">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password">New Password</label>

                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="new-password"
                    placeholder="••••••••"
                >

                @error('password')
                    <div class="alert-error">{{ $message }}</div>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>

                <input
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                    placeholder="••••••••"
                >

                @error('password_confirmation')
                    <div class="alert-error">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn-primary">
                Reset Password
            </button>

            <div class="text-center">
                <a href="{{ route('login') }}">Back to Login</a>
            </div>

        </form>

    </div>
</div>

</body>
</html>