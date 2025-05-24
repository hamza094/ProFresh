<?php

namespace Tests\Unit\Api\V1;

use PHPUnit\Framework\TestCase;
use App\Traits\HasSubscription;

class DummyUserWithSubscription
{
    use HasSubscription;
    public $mockSubscription = null;
    public function subscription($name)
    {
        return $this->mockSubscription;
    }
}

class HasSubscriptionTest extends TestCase
{
    public function test_is_subscribed_returns_true_when_subscription_exists()
    {
        $user = new DummyUserWithSubscription();
        $user->mockSubscription = 'fakeSubscription';
        $this->assertTrue($user->isSubscribed());
    }

    public function test_is_subscribed_returns_false_when_no_subscription()
    {
        $user = new DummyUserWithSubscription();
        $user->mockSubscription = null;
        $this->assertFalse($user->isSubscribed());
    }

    public function test_subscribed_plan_variants()
    {
        $user = new DummyUserWithSubscription();
        // Not Subscribed
        $user->mockSubscription = null;
        $this->assertEquals('Not Subscribed', $user->subscribedPlan());
        // Monthly
        $monthlyPlanId = 123;
        $user->mockSubscription = (object) ['paddle_plan' => $monthlyPlanId];
        $this->assertEquals('monthly', $user->subscribedPlan($monthlyPlanId, 456));
        // Yearly
        $yearlyPlanId = 456;
        $user->mockSubscription = (object) ['paddle_plan' => $yearlyPlanId];
        $this->assertEquals('yearly', $user->subscribedPlan($monthlyPlanId, $yearlyPlanId));
        // Unknown
        $user->mockSubscription = (object) ['paddle_plan' => 99999];
        $this->assertEquals('Unknown', $user->subscribedPlan($monthlyPlanId, $yearlyPlanId));
    }

    public function test_has_grace_period_true_and_false()
    {
        $user = new DummyUserWithSubscription();
        // True
        $user->mockSubscription = new class {
            public function onGracePeriod() { return true; }
        };
        $this->assertTrue($user->hasGracePeriod());
        // False
        $user->mockSubscription = new class {
            public function onGracePeriod() { return false; }
        };
        $this->assertFalse($user->hasGracePeriod());
        // No subscription
        $user->mockSubscription = null;
        $this->assertFalse($user->hasGracePeriod());
    }

    public function test_payment_returns_next_payment_and_no_active_subscription()
    {
        $user = new DummyUserWithSubscription();
        // Next payment
        $user->mockSubscription = new class {
            public function nextPayment() { return 'next payment date'; }
        };
        $this->assertEquals('next payment date', $user->payment());
        // No active subscription
        $user->mockSubscription = null;
        $this->assertEquals('No active subscription', $user->payment());
    }
}
