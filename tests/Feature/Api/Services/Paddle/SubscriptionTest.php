<?php

namespace Tests\Feature\Api\Services\Paddle;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\Api\V1\Paddle\SubscriptionService;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Mockery;
use App\Exceptions\Paddle\SubscriptionException;

class SubscriptionTest extends TestCase
{
    /** @test */
    public function it_throws_exception_for_already_subscribed_user()
    {
        $user = Mockery::mock(User::class);
        $user->shouldReceive('subscribed')->with('monthly')->andReturn(true);

        $service = new SubscriptionService();

        $this->expectException(SubscriptionException::class);
        $this->expectExceptionMessage('You are already subscribed to this plan.');

        $service->subscribe($user, 'monthly');
    }

    /** @test */
    public function it_throws_error_while_swapping_to_the_same_plan()
    {
        $user = Mockery::mock(User::class);
        $user->shouldReceive('subscribedPlan')->andReturn('yearly');

        $service = new SubscriptionService();

        $this->expectException(SubscriptionException::class);
        $this->expectExceptionMessage('You are already on this plan.');

        $service->swap($user, 'yearly');
    }

    /** @test */
    public function it_throws_exception_for_canceling_a_non_subscribed_plan()
    {
        $user = Mockery::mock(User::class);
        $user->shouldReceive('subscribed')->with('monthly')->andReturn(false);

        $service = new SubscriptionService();

        $this->expectException(SubscriptionException::class);
        $this->expectExceptionMessage('You are not subscribed to this plan.');

        $service->cancel($user, 'monthly');
    }
}
