@extends('layouts.app')

@section('title', 'Join Our Loom | SugarLoom PH')

@section('styles')
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --pink: #D8547B;
            --pink-light: #f0a0b8;
            --pink-pale: #fdf0f4;
            --pink-glow: rgba(216, 84, 123, 0.18);
            --caramel: #c4843f;
            --cream: #fef9f5;
            --text-dark: #2a1a20;
            --text-muted: #8a6070;
            --border: rgba(216, 84, 123, 0.15);
            --card-bg: rgba(255, 252, 250, 0.82);
        }

        * { box-sizing: border-box; }

        .auth-container {
            min-height: calc(100vh - 70px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px 24px;
            background: radial-gradient(ellipse 80% 60% at 70% 20%, rgba(216, 84, 123, 0.10) 0%, transparent 65%),
                        radial-gradient(ellipse 60% 50% at 10% 80%, rgba(196, 132, 63, 0.08) 0%, transparent 60%),
                        var(--cream);
            position: relative;
            overflow: hidden;
        }

        /* Decorative blobs */
        .auth-container::before,
        .auth-container::after {
            content: '';
            position: fixed;
            border-radius: 50%;
            pointer-events: none;
            z-index: 0;
        }
        .auth-container::before {
            width: 420px; height: 420px;
            top: -120px; right: -100px;
            background: radial-gradient(circle, rgba(216,84,123,0.12) 0%, transparent 70%);
        }
        .auth-container::after {
            width: 300px; height: 300px;
            bottom: -80px; left: -60px;
            background: radial-gradient(circle, rgba(196,132,63,0.10) 0%, transparent 70%);
        }

        .auth-card {
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.65);
            border-radius: 32px;
            padding: 48px 44px;
            max-width: 620px;
            width: 100%;
            box-shadow:
                0 2px 0 rgba(255,255,255,0.9) inset,
                0 24px 64px rgba(216, 84, 123, 0.12),
                0 8px 24px rgba(0,0,0,0.06);
            position: relative;
            z-index: 1;
        }

        /* Top accent line */
        .auth-card::before {
            content: '';
            position: absolute;
            top: 0; left: 10%; right: 10%;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--pink-light), var(--pink), var(--pink-light), transparent);
            border-radius: 0 0 2px 2px;
        }

        /* ── Header ── */
        .auth-header {
            text-align: center;
            margin-bottom: 36px;
        }

        .auth-header .icon-wrap {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 64px; height: 64px;
            border-radius: 20px;
            background: linear-gradient(135deg, #fce8f0 0%, #fdf3eb 100%);
            border: 1px solid rgba(216, 84, 123, 0.2);
            font-size: 28px;
            margin-bottom: 16px;
            box-shadow: 0 4px 16px rgba(216,84,123,0.12);
        }

        .auth-header h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-dark);
            letter-spacing: -0.5px;
            margin: 0 0 8px;
        }

        .auth-header p {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.92rem;
            color: var(--text-muted);
            margin: 0;
        }

        /* ── Form ── */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px 18px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group.full {
            grid-column: span 2;
        }

        .form-group label {
            font-family: 'DM Sans', sans-serif;
            display: block;
            font-weight: 600;
            font-size: 11px;
            color: var(--text-muted);
            margin-bottom: 7px;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 11px 15px;
            background: rgba(255, 255, 255, 0.6);
            border: 1.5px solid var(--border);
            border-radius: 12px;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            color: var(--text-dark);
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
        }

        .form-group input::placeholder {
            color: #c0a0ad;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            background: #fff;
            border-color: var(--pink);
            box-shadow: 0 0 0 3px rgba(216, 84, 123, 0.12);
        }

        /* ── Password ── */
        .password-wrap {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 13px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--pink);
            font-family: 'DM Sans', sans-serif;
            font-size: 11px;
            font-weight: 700;
            cursor: pointer;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 4px 6px;
            border-radius: 6px;
            transition: background 0.15s;
        }
        .password-toggle:hover {
            background: rgba(216,84,123,0.08);
        }

        /* ── Strength meter ── */
        .strength-meter {
            margin-top: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .meter-bar {
            flex: 1;
            height: 3px;
            background: rgba(216, 84, 123, 0.1);
            border-radius: 99px;
            overflow: hidden;
        }

        .meter-bar div {
            height: 100%;
            width: 0;
            border-radius: 99px;
            transition: width 0.35s ease, background 0.35s ease;
        }

        .meter-label {
            font-family: 'DM Sans', sans-serif;
            font-size: 10.5px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            white-space: nowrap;
        }

        .strength-weak .meter-bar div   { width: 33%; background: #f87171; }
        .strength-weak .meter-label     { color: #f87171; }
        .strength-normal .meter-bar div { width: 66%; background: #fb923c; }
        .strength-normal .meter-label   { color: #fb923c; }
        .strength-strong .meter-bar div { width: 100%; background: #34d399; }
        .strength-strong .meter-label   { color: #34d399; }

        .error-message {
            color: #f87171;
            font-family: 'DM Sans', sans-serif;
            font-size: 11.5px;
            margin-top: 5px;
            font-weight: 500;
        }

        /* ── Alert ── */
        .alert-error {
            background: rgba(254, 226, 226, 0.75);
            border: 1px solid #fecaca;
            color: #b91c1c;
            padding: 14px 18px;
            border-radius: 12px;
            margin-bottom: 24px;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.84rem;
        }

        /* ── Submit button ── */
        .btn-register {
            display: block;
            width: 100%;
            padding: 15px 24px;
            margin-top: 28px;
            background: linear-gradient(135deg, #e0607f 0%, var(--pink) 50%, #c4457a 100%);
            color: #fff;
            border: none;
            border-radius: 14px;
            font-family: 'DM Sans', sans-serif;
            font-weight: 700;
            font-size: 0.97rem;
            letter-spacing: 0.3px;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s, opacity 0.2s;
            box-shadow: 0 6px 20px rgba(216, 84, 123, 0.35), 0 1px 0 rgba(255,255,255,0.15) inset;
            position: relative;
            overflow: hidden;
        }

        .btn-register::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(255,255,255,0.12) 0%, transparent 60%);
            pointer-events: none;
        }

        .btn-register:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 10px 28px rgba(216, 84, 123, 0.42), 0 1px 0 rgba(255,255,255,0.15) inset;
        }

        .btn-register:active:not(:disabled) {
            transform: translateY(0);
        }

        .btn-register:disabled {
            opacity: 0.45;
            cursor: not-allowed;
            box-shadow: none;
        }

        /* ── Footer ── */
        .auth-footer {
            text-align: center;
            margin-top: 22px;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.88rem;
            color: var(--text-muted);
        }

        .auth-footer a {
            color: var(--pink);
            text-decoration: none;
            font-weight: 700;
            transition: opacity 0.15s;
        }
        .auth-footer a:hover { opacity: 0.75; }

        /* ── Divider between sections ── */
        .form-section-label {
            grid-column: span 2;
            font-family: 'DM Sans', sans-serif;
            font-size: 10.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--pink-light);
            padding-top: 6px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .form-section-label::before,
        .form-section-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        @media (max-width: 640px) {
            .auth-card { padding: 32px 22px; border-radius: 24px; }
            .form-grid { grid-template-columns: 1fr; gap: 12px; }
            .form-group.full,
            .form-section-label { grid-column: auto; }
            .form-section-label::before,
            .form-section-label::after { display: none; }
            .auth-header h2 { font-size: 1.65rem; }
        }
    </style>
@endsection

@section('content')
<div class="auth-container">
    <div class="auth-card" data-aos="fade-up" data-aos-duration="700">

        <div class="auth-header">
            <div class="icon-wrap">🍪</div>
            <h2>Join Our Loom</h2>
            <p>Create an account to start weaving your sweet dreams</p>
        </div>

        @if ($errors->any())
            <div class="alert-error">
                <ul style="margin: 0; padding-left: 18px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-grid">

                {{-- Account Info --}}
                <div class="form-section-label">Account</div>

                <div class="form-group full">
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

                {{-- Shipping Info --}}
                <div class="form-section-label">Delivery</div>

                <div class="form-group full">
                    <label for="shipping_address">Shipping Address</label>
                    <input id="shipping_address" type="text" name="shipping_address" value="{{ old('shipping_address') }}" required placeholder="123 Artisanal Lane, Flour District">
                </div>

                <div class="form-group">
                    <label for="city">City</label>
                    <select id="city" name="city" required>
                        <option value="">Select a Metro Manila city</option>
                        @foreach(config('sugarloom.metro_manila_cities', []) as $metroCity)
                            <option value="{{ $metroCity }}" @selected(old('city') === $metroCity)>{{ $metroCity }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="postal_code">Postal Code</label>
                    <input id="postal_code" type="text" name="postal_code" value="{{ old('postal_code') }}" required placeholder="1000">
                </div>

                {{-- Password --}}
                <div class="form-section-label">Security</div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="password-wrap">
                        <input id="password" type="password" name="password" required placeholder="••••••••" oninput="checkStrength(this.value)">
                        <button class="password-toggle" type="button" onclick="togglePass('password', this)">Show</button>
                    </div>
                    <div id="password-strength" class="strength-meter">
                        <div class="meter-bar"><div></div></div>
                        <span class="meter-label">Enter a password</span>
                    </div>
                    @error('password') <p class="error-message">{{ $message }}</p> @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <div class="password-wrap">
                        <input id="password_confirmation" type="password" name="password_confirmation" required placeholder="••••••••" oninput="checkMatch()">
                        <button class="password-toggle" type="button" onclick="togglePass('password_confirmation', this)">Show</button>
                    </div>
                    <p id="password-match-error" class="error-message" style="display: none;">Passwords do not match.</p>
                </div>

            </div>

            <button type="submit" class="btn-register" id="submitBtn">
                Begin Your Journey ✦
            </button>

            <div class="auth-footer">
                Already part of the loom? <a href="{{ route('login') }}">Log in here</a>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({ once: true, duration: 700, easing: 'ease-out-cubic' });

    function togglePass(id, btn) {
        const input = document.getElementById(id);
        input.type = input.type === 'password' ? 'text' : 'password';
        btn.textContent = input.type === 'password' ? 'Show' : 'Hide';
    }

    function checkStrength(pass) {
        const meter = document.getElementById('password-strength');
        const label = meter.querySelector('.meter-label');

        meter.className = 'strength-meter';

        if (!pass) {
            label.textContent = 'Enter a password';
            window.currentPasswordIsWeak = true;
            updateBtn();
            return;
        }

        let strength = 0;
        if (pass.length >= 8) strength++;
        if (/[A-Z]/.test(pass) || /[0-9]/.test(pass)) strength++;
        if (/[^A-Za-z0-9]/.test(pass) && pass.length >= 10) strength++;

        if (strength === 0 || pass.length < 6) {
            meter.classList.add('strength-weak');
            label.textContent = 'Weak — keep weaving!';
            window.currentPasswordIsWeak = true;
        } else if (strength <= 2) {
            meter.classList.add('strength-normal');
            label.textContent = 'Normal — sweet enough';
            window.currentPasswordIsWeak = false;
        } else {
            meter.classList.add('strength-strong');
            label.textContent = 'Strong — dream bake!';
            window.currentPasswordIsWeak = false;
        }

        checkMatch();
    }

    function checkMatch() {
        const pass    = document.getElementById('password').value;
        const confirm = document.getElementById('password_confirmation').value;
        const error   = document.getElementById('password-match-error');

        const mismatch = confirm && pass !== confirm;
        error.style.display = mismatch ? 'block' : 'none';
        window.passwordMismatch = mismatch;
        updateBtn();
    }

    function updateBtn() {
        const pass   = document.getElementById('password').value;
        const btn    = document.getElementById('submitBtn');
        const block  = !pass || window.currentPasswordIsWeak || window.passwordMismatch;
        btn.disabled = block;
    }
</script>
@endsection
