@extends('layouts.app')

@section('title', 'Welcome Back | SugarLoom PH')

@section('styles')
    <style>
        .auth-container {
            min-height: calc(100vh - 70px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 24px;
        }

        .auth-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            border-radius: 28px;
            padding: 48px 40px;
            max-width: 450px;
            width: 100%;
            box-shadow: 0 20px 60px rgba(216, 84, 123, 0.1);
        }

        .auth-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .auth-header .cookie-icon {
            font-size: 40px;
            margin-bottom: 12px;
            display: block;
        }

        .auth-header h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2.2rem;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .auth-header p {
            font-size: 0.95rem;
            color: var(--text-accent);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            font-size: 13px;
            color: var(--text-dark);
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-group input {
            width: 100%;
            padding: 14px 18px;
            background: rgba(255, 255, 255, 0.5);
            border: 1px solid rgba(216, 84, 123, 0.2);
            border-radius: 12px;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            color: var(--text-dark);
            transition: all 0.3s;
        }

        .form-group input:focus {
            outline: none;
            background: white;
            border-color: var(--pink-btn);
            box-shadow: 0 0 0 4px rgba(216, 84, 123, 0.1);
        }

        .password-wrap {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--pink-btn);
            font-size: 0.8rem;
            font-weight: 700;
            cursor: pointer;
            text-transform: uppercase;
        }

        .auth-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            font-size: 0.85rem;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--text-body);
            cursor: pointer;
        }

        .remember-me input {
            accent-color: var(--pink-btn);
            width: 16px;
            height: 16px;
        }

        .forgot-password {
            color: var(--text-accent);
            text-decoration: none;
            font-weight: 600;
        }

        .forgot-password:hover {
            color: var(--pink-btn);
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: var(--pink-btn);
            color: white;
            border: none;
            border-radius: 999px;
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 8px 20px rgba(216, 84, 123, 0.3);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(216, 84, 123, 0.4);
        }

        .auth-footer {
            text-align: center;
            margin-top: 32px;
            font-size: 0.9rem;
            color: var(--text-body);
        }

        .auth-footer a {
            color: var(--pink-btn);
            text-decoration: none;
            font-weight: 700;
        }

        .status-message {
            background: rgba(22, 101, 34, 0.1);
            color: #166534;
            padding: 14px;
            border-radius: 12px;
            margin-bottom: 24px;
            font-size: 0.9rem;
            text-align: center;
        }

        .error-list {
            background: rgba(185, 28, 28, 0.1);
            color: #b91c1c;
            padding: 14px;
            border-radius: 12px;
            margin-bottom: 24px;
            font-size: 0.85rem;
        }

        @media (max-width: 480px) {
            .auth-card {
                padding: 40px 24px;
            }
        }
    </style>
@endsection

@section('content')
<div class="auth-container">
    <div class="auth-card" data-aos="zoom-in">
        <div class="auth-header">
            <span class="cookie-icon">🍪</span>
            <h2>Welcome Back</h2>
            <p>Sign in to your sweet account</p>
        </div>

        @if (session('status'))
            <div class="status-message">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div class="error-list">
                <ul style="margin: 0; list-style: none; padding: 0;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="juan@example.com">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="password-wrap">
                    <input id="password" type="password" name="password" required placeholder="••••••••">
                    <button class="password-toggle" type="button" onclick="togglePassword()">Show</button>
                </div>
            </div>

            <div class="auth-options">
                <label class="remember-me" for="remember_me">
                    <input id="remember_me" type="checkbox" name="remember">
                    <span>Remember me</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="forgot-password" href="{{ route('password.request') }}">
                        Forgot password?
                    </a>
                @endif
            </div>

            <button type="submit" class="btn-login">Sign In</button>

            <div class="auth-footer">
                New here? <a href="{{ route('register') }}">Create an account</a>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
        once: true,
        duration: 800,
        easing: 'ease-out-cubic'
    });

    function togglePassword() {
        const input = document.getElementById('password');
        const btn = document.querySelector('.password-toggle');
        if (input.type === 'password') {
            input.type = 'text';
            btn.textContent = 'Hide';
        } else {
            input.type = 'password';
            btn.textContent = 'Show';
        }
    }
</script>
@endsection
