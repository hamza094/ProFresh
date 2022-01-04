<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use App\Models\User;

use Illuminate\{
  Foundation\Testing\RefreshDatabase,
  Foundation\Testing\WithFaker,
  Auth\Events\Verified,
  Support\Facades\Event,
  Support\Facades\URL,
  Auth\Notifications\VerifyEmail,
  Support\Facades\Notification
};

class VerificationTest extends TestCase
{
  use RefreshDatabase;
  /** @test */
 public function can_verify_email()
 {
     $user = User::factory()->create(['email_verified_at' => null]);
     $url = URL::temporarySignedRoute('verification.verify', now()->addMinutes(60), ['id' => $user->id]);

     Event::fake();

     $this->postJson($url)
         ->assertSuccessful()
         ->assertJsonFragment(['status' => 'verification.verified']);

     Event::assertDispatched(Verified::class, function (Verified $e) use ($user) {
         return $e->user->is($user);
     });
 }

/** @test */
 public function can_not_verify_if_already_verified()
 {
     $user = User::factory()->create();
     $url = URL::temporarySignedRoute('verification.verify', now()->addMinutes(60), ['id' => $user->id]);

     $this->postJson($url)
         ->assertStatus(400)
         ->assertJsonFragment(['status' => 'verification.already_verified']);
 }

   /** @test */
  public function resend_verification_notification()
  {
     $user = User::factory()->create(['email_verified_at' => null]);

     Sanctum::actingAs(
         $user,
     );

     Notification::fake();

    $this->postJson('/api/v1/email/resend/'.$user->id, ['email' => $user->email])
       ->assertSuccessful();

    Notification::assertSentTo($user, VerifyEmail::class);
  }

  /** @test */
 public function can_not_resend_verification_notification_if_email_already_verified()
 {
     $user = User::factory()->create();

     Sanctum::actingAs(
         $user,
     );

     Notification::fake();

     $this->postJson('/api/v1/email/resend/'.$user->id, ['email' => $user->email])
         ->assertStatus(422)
         ->assertJsonFragment(['errors' => ['email' => ['verification.already_verified']]]);

     Notification::assertNotSentTo($user, VerifyEmail::class);
 }
}
