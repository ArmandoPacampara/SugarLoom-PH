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
            --card-bg: rgba(255, 252, 250, 0.95);
        }

        body, html {
            height: 100vh;
            overflow: hidden !important;
            margin: 0;
            padding: 0;
        }

        .auth-container {
            height: calc(100vh - 70px);
            display: flex;
            align-items: center;
            justify-content: center;
            background: radial-gradient(ellipse 80% 60% at 70% 20%, rgba(216, 84, 123, 0.10) 0%, transparent 65%),
                        radial-gradient(ellipse 60% 50% at 10% 80%, rgba(196, 132, 63, 0.08) 0%, transparent 60%),
                        var(--cream);
            position: relative;
            overflow: hidden;
            padding: 20px;
        }

        .auth-card {
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            border-radius: 32px;
            padding: 40px;
            max-width: 500px;
            width: 100%;
            box-shadow: 0 24px 64px rgba(216, 84, 123, 0.12);
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            max-height: 90vh;
        }

        .auth-header {
            text-align: center;
            margin-bottom: 24px;
        }

        .auth-header h2 {
            font-family: 'Playfair Display', serif;
            font-size: 1.75rem;
            margin: 0;
            color: var(--text-dark);
        }

        /* ── STEPS ── */
        .step-indicators {
            display: flex;
            justify-content: center;
            gap: 12px;
            margin-bottom: 30px;
        }

        .step-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: var(--pink-light);
            opacity: 0.3;
            transition: all 0.3s;
        }

        .step-dot.active {
            opacity: 1;
            background: var(--pink);
            transform: scale(1.3);
        }

        .form-step {
            display: none;
            animation: fadeIn 0.4s ease-out;
        }

        .form-step.active {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            font-weight: 700;
            font-size: 11px;
            color: var(--text-muted);
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        .form-group input, .form-group select {
            width: 100%;
            padding: 12px 16px;
            background: #fff;
            border: 1.5px solid var(--border);
            border-radius: 14px;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            transition: all 0.2s;
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--pink);
            box-shadow: 0 0 0 3px rgba(216, 84, 123, 0.1);
        }

        /* ── PASSWORD FEATURES ── */
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
        }

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

        /* ── BUTTONS ── */
        .step-actions {
            display: flex;
            gap: 12px;
            margin-top: 24px;
        }

        .btn {
            flex: 1;
            padding: 14px;
            border-radius: 14px;
            font-weight: 700;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
            font-family: 'DM Sans', sans-serif;
        }

        .btn-next, .btn-submit {
            background: var(--pink);
            color: white;
            box-shadow: 0 4px 12px rgba(216, 84, 123, 0.2);
        }

        .btn-next:hover, .btn-submit:hover {
            transform: translateY(-2px);
            opacity: 0.9;
        }

        .btn-back {
            background: #fff;
            color: var(--text-muted);
            border: 1.5px solid var(--border);
        }

        .btn-back:hover {
            background: var(--pink-pale);
        }

        .auth-footer {
            margin-top: 24px;
            text-align: center;
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        .auth-footer a {
            color: var(--pink);
            font-weight: 700;
            text-decoration: none;
        }

        .error-msg {
            color: #f87171;
            font-size: 11px;
            margin-top: 4px;
            font-weight: 500;
        }

        .alert-error {
            background: rgba(254, 226, 226, 0.75);
            border: 1px solid #fecaca;
            color: #b91c1c;
            padding: 12px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 0.8rem;
        }
    </style>
@endsection

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h2>Join Our Loom</h2>
        </div>

        <div class="step-indicators">
            <div class="step-dot active" data-step="1"></div>
            <div class="step-dot" data-step="2"></div>
            <div class="step-dot" data-step="3"></div>
        </div>

        @if ($errors->any())
            <div class="alert-error">
                <ul style="margin: 0; padding-left: 15px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" id="regForm">
            @csrf

            <!-- STEP 1: ACCOUNT -->
            <div class="form-step active" id="step1">
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="Juan Dela Cruz">
                </div>
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="juan@example.com">
                </div>
                <div class="form-group">
                    <label>Mobile Number</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" required placeholder="09171234567" maxlength="11" onkeypress="return event.charCode >= 48 && event.charCode <= 57" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                </div>
                <div class="step-actions">
                    <button type="button" class="btn btn-next" onclick="nextStep(2)">Continue ✦</button>
                </div>
            </div>

            <!-- STEP 2: LOCATION -->
            <div class="form-step" id="step2">
                <div class="form-group">
                    <label>Shipping Address</label>
                    <input type="text" name="shipping_address" value="{{ old('shipping_address') }}" required placeholder="Unit 123, Street Name">
                </div>
                <div class="form-group">
                    <label>City</label>
                    <select name="city" required>
                        <option value="">Select City</option>
                        @foreach(config('sugarloom.metro_manila_cities', []) as $city)
                            <option value="{{ $city }}" @selected(old('city') === $city)>{{ $city }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Postal Code</label>
                    <input type="text" name="postal_code" value="{{ old('postal_code') }}" required placeholder="1000">
                </div>
                <div class="step-actions">
                    <button type="button" class="btn btn-back" onclick="nextStep(1)">Back</button>
                    <button type="button" class="btn btn-next" onclick="nextStep(2.5)">Next</button>
                </div>
            </div>

            <!-- STEP 3: SECURITY -->
            <div class="form-step" id="step3">
                <div class="form-group">
                    <label>Password</label>
                    <div class="password-wrap">
                        <input id="password" type="password" name="password" required placeholder="••••••••" oninput="checkStrength(this.value)">
                        <button class="password-toggle" type="button" onclick="togglePass('password', this)">Show</button>
                    </div>
                    <div id="password-strength" class="strength-meter">
                        <div class="meter-bar"><div></div></div>
                        <span class="meter-label">Enter a password</span>
                    </div>
                </div>

                <div class="form-group">
                    <label>Confirm Password</label>
                    <div class="password-wrap">
                        <input id="password_confirmation" type="password" name="password_confirmation" required placeholder="••••••••" oninput="checkMatch()">
                        <button class="password-toggle" type="button" onclick="togglePass('password_confirmation', this)">Show</button>
                    </div>
                    <p id="password-match-error" class="error-msg" style="display: none;">Passwords do not match.</p>
                </div>

                <div class="step-actions">
                    <button type="button" class="btn btn-back" onclick="nextStep(2)">Back</button>
                    <button type="submit" class="btn btn-submit" id="submitBtn">Complete ✦</button>
                </div>
            </div>

            <div class="auth-footer">
                Already part of the loom? <a href="{{ route('home', ['login' => 'true']) }}">Log in</a>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
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
            return;
        }

        let strength = 0;
        if (pass.length >= 8) strength++;
        if (/[A-Z]/.test(pass) || /[0-9]/.test(pass)) strength++;
        if (/[^A-Za-z0-9]/.test(pass) && pass.length >= 10) strength++;

        if (strength === 0 || pass.length < 6) {
            meter.classList.add('strength-weak');
            label.textContent = 'Weak — keep weaving!';
        } else if (strength <= 2) {
            meter.classList.add('strength-normal');
            label.textContent = 'Normal — sweet enough';
        } else {
            meter.classList.add('strength-strong');
            label.textContent = 'Strong — dream bake!';
        }
        checkMatch();
    }

    function checkMatch() {
        const pass = document.getElementById('password').value;
        const confirm = document.getElementById('password_confirmation').value;
        const error = document.getElementById('password-match-error');
        const mismatch = confirm && pass !== confirm;
        error.style.display = mismatch ? 'block' : 'none';
    }

    function nextStep(step) {
        if (step === 2.5) step = 3; // Normalize if needed
        
        const currentStep = document.querySelector('.form-step.active');
        const inputs = currentStep.querySelectorAll('input, select');
        let valid = true;
        
        const currentStepNum = parseInt(currentStep.id.replace('step', ''));
        if (step > currentStepNum) {
            inputs.forEach(input => {
                if (input.hasAttribute('required') && !input.value) {
                    input.style.borderColor = '#f87171';
                    valid = false;
                } else {
                    input.style.borderColor = 'rgba(216, 84, 123, 0.15)';
                }
            });
        }

        if (!valid) return;

        document.querySelectorAll('.form-step').forEach(s => s.classList.remove('active'));
        document.getElementById('step' + step).classList.add('active');

        document.querySelectorAll('.step-dot').forEach((dot, idx) => {
            dot.classList.toggle('active', (idx + 1) === step);
        });
    }

    // If there were validation errors, jump to the last step where they likely occurred
    @if ($errors->any())
        document.addEventListener('DOMContentLoaded', () => {
            nextStep(3);
        });
    @endif
</script>
@endsection
