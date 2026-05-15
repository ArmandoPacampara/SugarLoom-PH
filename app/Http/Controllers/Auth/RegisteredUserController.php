<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\RegistrationVerificationCode;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required', 'string', 'max:30'],
            'shipping_address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:80', Rule::in(config('sugarloom.metro_manila_cities', []))],
            'postal_code' => ['required', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Rules\Password::min(8)->letters()->numbers()],
        ]);

        $code = (string) random_int(100000, 999999);

        session([
            'pending_registration' => [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'shipping_address' => $validated['shipping_address'],
                'city' => $validated['city'],
                'postal_code' => $validated['postal_code'],
                'password' => Hash::make($validated['password']),
                'role' => User::ROLE_CUSTOMER,
                'code_hash' => Hash::make($code),
                'expires_at' => now()->addMinutes(10)->toIso8601String(),
            ],
        ]);

        Mail::to($validated['email'])->send(new RegistrationVerificationCode($code, $validated['name']));

        return redirect()
            ->route('register.verify')
            ->with('status', 'We sent a verification code to your email. Enter it below to finish creating your account.');
    }

    public function showVerificationForm(): View|RedirectResponse
    {
        if (! session()->has('pending_registration')) {
            return redirect()->route('register');
        }

        return view('auth.verify-registration', [
            'email' => session('pending_registration.email'),
        ]);
    }

    public function verify(Request $request): RedirectResponse
    {
        $request->validate([
            'code' => ['required', 'digits:6'],
        ]);

        $pending = session('pending_registration');

        if (! $pending) {
            return redirect()->route('register');
        }

        if (now()->greaterThan($pending['expires_at'])) {
            throw ValidationException::withMessages([
                'code' => 'That verification code has expired. Please request a new one.',
            ]);
        }

        if (! Hash::check($request->code, $pending['code_hash'])) {
            throw ValidationException::withMessages([
                'code' => 'The verification code is incorrect.',
            ]);
        }

        validator($pending, [
            'email' => ['required', 'email', Rule::unique(User::class, 'email')],
        ])->validate();

        $user = User::create([
            'name' => $pending['name'],
            'email' => $pending['email'],
            'phone' => $pending['phone'],
            'shipping_address' => $pending['shipping_address'],
            'city' => $pending['city'],
            'postal_code' => $pending['postal_code'],
            'password' => $pending['password'],
            'role' => $pending['role'],
        ]);

        session()->forget('pending_registration');

        event(new Registered($user));

        Auth::login($user);

        return redirect(route($user->homeRoute(), absolute: false));
    }

    public function resendCode(): RedirectResponse
    {
        $pending = session('pending_registration');

        if (! $pending) {
            return redirect()->route('register');
        }

        $code = (string) random_int(100000, 999999);
        $pending['code_hash'] = Hash::make($code);
        $pending['expires_at'] = now()->addMinutes(10)->toIso8601String();
        session(['pending_registration' => $pending]);

        Mail::to($pending['email'])->send(new RegistrationVerificationCode($code, $pending['name']));

        return back()->with('status', 'A new verification code has been sent.');
    }
}
