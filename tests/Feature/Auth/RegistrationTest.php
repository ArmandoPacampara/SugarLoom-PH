<?php

namespace Tests\Feature\Auth;

use App\Mail\RegistrationVerificationCode;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        Mail::fake();

        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '+63 917 111 2222',
            'shipping_address' => '123 Test Street',
            'city' => 'Manila',
            'postal_code' => '1000',
            'password' => 'password1',
            'password_confirmation' => 'password1',
        ]);

        $this->assertGuest();
        $response->assertRedirect(route('register.verify', absolute: false));
        $this->assertNotNull(session('pending_registration'));
        Mail::assertSent(RegistrationVerificationCode::class);
    }
}
