<?php

namespace App\Services\Api\V1\Paddle;
use App\Interfaces\Paddle;
use App\Models\User;
use App\Exceptions\Paddle\SubscriptionException;

final class SubscriptionService implements Paddle
{
    public function subscribe(User $user, string $plan): mixed
    {
        if ($user->subscribedPlan() === $plan) {
            throw new SubscriptionException('You are already subscribed to this plan.');
        }

        return $user->newSubscription('ProFresh', config('services.paddle.' . $plan))
            ->returnTo('http://localhost:8000/subscriptions')
            ->create();
    }

    /**
     * @return array{message: string}
     */
    public function swap(User $user, string $plan): array
    {
        $currentPlan = $user->subscribedPlan();

        if ($currentPlan === $plan) {
            throw new SubscriptionException('You are already on this plan.');
        }

        $user->subscription('ProFresh')->swapAndInvoice(config('services.paddle.' . $plan));

        return [
            'message' => 'Your subscription has been successfully updated to the ' . $plan . ' plan',
        ];
    }

    /**
     * @return array{message: string}
     */
    public function cancel(User $user, string $plan): array
    {
        if ($user->subscribedPlan() !== $plan) {
            throw new SubscriptionException('You are not subscribed to this plan.');
        }

        $user->subscription('ProFresh')->cancel();

        return [
            'message' => 'Your subscription has been canceled successfully.',
        ];
    }
}