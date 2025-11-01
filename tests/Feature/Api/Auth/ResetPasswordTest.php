<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Auth;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class ResetPasswordTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Sends the password reset email when the user exists.
     *
     * @return void
     */

    /** @test */
    public function can_sends_password_reset_email()
    {
        $user = User::factory()->create();

        Notification::fake();

        $this->postJson('/api/v1/forgot-password', ['email' => $user->email]);

        Notification::assertSentTo($user, ResetPassword::class);
    }

    /**
     * Allows a user to reset their password.
     *
     * @return void
     */

    /** @test */
    public function user_reset_their_password()
    {
        $user = User::factory()->create();

        $token = Password::createToken($user);

        $this->postJson('/api/v1/reset-password', [
            'token' => $token,
            'email' => $user->email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ])->assertStatus(302);

        $this->assertTrue(Hash::check('password', $user->fresh()->password));
    }
}
