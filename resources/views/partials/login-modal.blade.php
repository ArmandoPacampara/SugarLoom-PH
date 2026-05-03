@guest
<div class="login-overlay {{ $errors->any() || session('status') ? 'is-open' : '' }}" id="loginModal" aria-hidden="{{ $errors->any() || session('status') ? 'false' : 'true' }}">
    <section class="login-popup" role="dialog" aria-modal="true" aria-labelledby="loginTitle">
        <button type="button" class="login-close" data-login-close aria-label="Close login">&times;</button>

        <div class="login-copy">
            <h2>Welcome back,<span>sweet soul.</span></h2>
            <p>Sign in to continue shopping small-batch treats, track your orders, or manage the SugarLoom dashboard.</p>
        </div>

        <div class="login-panel">
            <h2 id="loginTitle">Log in</h2>
            <p class="subtext">Use your SugarLoom account to continue.</p>

            @if (session('status'))
                <div class="login-status">{{ session('status') }}</div>
            @endif

            @if ($errors->any())
                <div class="login-errors">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="login-field">
                    <label for="modal-email">Email</label>
                    <input id="modal-email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username">
                    <span class="login-hint">Never shown to the public.</span>
                </div>

                <div class="login-field">
                    <label for="modal-password">Password</label>
                    <input id="modal-password" type="password" name="password" required autocomplete="current-password">
                </div>

                <div class="login-row">
                    <label class="login-remember" for="modal-remember">
                        <input id="modal-remember" type="checkbox" name="remember">
                        <span>Remember me</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="login-forgot" href="{{ route('password.request') }}">Forgot password?</a>
                    @endif
                </div>

                <button type="submit" class="login-submit">Log in</button>
            </form>

            @if (Route::has('register'))
                <p class="login-register">New here? <a href="{{ route('register') }}">Create an account</a></p>
            @endif
        </div>
    </section>
</div>
@endguest
