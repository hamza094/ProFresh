<?php

namespace App\Traits;

trait HasSubscription
{
    private const SUBSCRIPTION_NAME = 'ProFresh';

    /**
     * Check if the user is subscribed to the ProFresh plan.
     */
    public function isSubscribed(): bool
    {
        return (bool) $this->getSubscription();
    }

    /**
     * Get the user's current subscription plan name ('monthly', 'yearly', 'Not Subscribed', or 'Unknown').
     * Optionally accepts plan IDs for testability.
     */
    public function subscribedPlan(int $monthlyPlanId = null, int $yearlyPlanId = null): string
    {
        $subscription = $this->getSubscription();
        if (!$subscription) {
            return 'Not Subscribed';
        }
        $monthlyPlanId = $monthlyPlanId ?? (int) config('services.paddle.monthly');
        $yearlyPlanId = $yearlyPlanId ?? (int) config('services.paddle.yearly');
        $plans = [
            $monthlyPlanId => 'monthly',
            $yearlyPlanId  => 'yearly',
        ];
        return $plans[$subscription->paddle_plan] ?? 'Unknown';
    }

    /**
     * Determine if the user's subscription is in a grace period.
     */
    public function hasGracePeriod(): bool
    {
        $subscription = $this->getSubscription();
        return $subscription ? $subscription->onGracePeriod() : false;
    }

    /**
     * Get the user's next payment for the ProFresh subscription, or a message if not subscribed.
     *
     * @return mixed
     */
    public function payment(): mixed
    {
        $subscription = $this->getSubscription();
        return $subscription ? $subscription->nextPayment() : 'No active subscription';
    }

    /**
     * Helper to get the ProFresh subscription instance.
     *
     * @return mixed
     */
     function getSubscription(): mixed
    {
        return $this->subscription(self::SUBSCRIPTION_NAME);
    }
}
