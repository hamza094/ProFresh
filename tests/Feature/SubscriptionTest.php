<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SubscriptionTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    /** @test */
    public function user_swap_their_subscription_plan()
    {
        $this->get('/api/v1/user/subscription/swap/monthly');

        //$response->assertStatus(200);
    }
}
