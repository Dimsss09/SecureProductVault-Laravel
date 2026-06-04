<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class EmailSendingTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_sends_email_verification_notification(): void
    {
        Notification::fake();

        $this->post(route('register'), [
            'name' => 'Documentation User',
            'email' => 'documentation@example.test',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ])->assertRedirect('/home');

        $user = User::where('email', 'documentation@example.test')->firstOrFail();

        Notification::assertSentTo($user, VerifyEmail::class);
    }

    public function test_password_reset_request_sends_reset_notification(): void
    {
        Notification::fake();

        $user = User::factory()->create([
            'email' => 'reset@example.test',
        ]);

        $this->post(route('password.email'), [
            'email' => $user->email,
        ])->assertSessionHas('status', trans('passwords.sent'));

        Notification::assertSentTo($user, ResetPassword::class);
    }
}
