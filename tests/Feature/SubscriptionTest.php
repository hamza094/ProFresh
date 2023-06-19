<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Paddle\Http\Middleware\VerifyWebhookSignature;
use Laravel\Paddle\Cashier;
use Laravel\Paddle\Events\PaymentSucceeded;
use Laravel\Paddle\Events\SubscriptionCancelled;
use Laravel\Paddle\Events\SubscriptionCreated;
use Laravel\Paddle\Events\SubscriptionPaymentSucceeded;
use Laravel\Paddle\Events\SubscriptionUpdated;
use Illuminate\Support\Facades\Http;
use Laravel\Paddle\Subscription;
use App\Traits\ProjectSetup;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Laravel\Paddle\Billable;
use Laravel\Paddle\Http\Client as PaddleClient;
use Mockery;

use Tests\TestCase;

class SubscriptionTest extends TestCase
{
    use RefreshDatabase,ProjectSetup,WithoutMiddleware;
    /**
     * A basic feature test example.
     *
     * @return void
     */


   
    /** @test */
    public function create_paylink_for_subscription()
    {
        // Fake the HTTP response
        Http::fake([
            '*' => Http::response([
                'success' => true,
                'response' => [
                    'url' => 'https://sandbox-checkout-url'
                ]
            ], 200),
        ]);

        // Perform the subscription request
        $response = $this->getJson('/api/v1/user/subscribe/monthly');

        // Assert the response
        $response->assertStatus(200)
            ->assertJson([
                'paylink' => 'https://sandbox-checkout-url',
            ]);
    }

    
    public function user_swap_their_subscription_plan()
    {       
        // Mock the Paddle API response
    Http::fake([
        'api.paddle.com/*' => Http::response(['success' => true, 'subscription_id' => 'sub_1234567890']),
    ]);

    // Create the subscription for the user
    $subscriptionId = 'sub_1234567890';

    $this->user->newSubscription('default', 'plan_123')
        ->create($subscriptionId);

    // Swap the subscription plan
    $response = $this->actingAs($this->user)
        ->withoutExceptionHandling()
        ->postJson('/api/v1/user/subscription/swap', ['plan' => 'yearly']);

    // Assert the response status
    $response->assertStatus(200);
    }

    /** @test */
    public function a_subscription_can_be_canceled()
   {
             // Mock the Paddle API response for cancelling the subscription
        Http::fake([
            'api.paddle.com/*' => Http::response(['success' => true, 'subscription_id' => 'sub_1234567890']),
        ]);

        $subscriptionId = 'sub_1234567890';

        $this->user->subscriptions()->create([
            'name' => 'monthly',
            'paddle_id' => $subscriptionId,
            'paddle_plan' => 'plan_123',
            'quantity' => 1,
            'paddle_status' => 'active',
        ]);

        // Call the cancel method on the controller
        $response = $this->getJson('/api/v1/subscription/monthly/cancel');

        // Assert the response
        $response->assertStatus(200);
   }
}
