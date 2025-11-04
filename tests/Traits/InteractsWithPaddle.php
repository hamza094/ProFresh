<?php

declare(strict_types=1);

namespace Tests\Traits;

use App\Interfaces\Paddle;
use App\Services\Api\V1\Paddle\SubscriptionServiceFake;

trait InteractsWithPaddle
{
    private function fakeSubscription(): SubscriptionServiceFake
    {
        $subscriptionServiceFake = new SubscriptionServiceFake;

        $this->swap(Paddle::class, $subscriptionServiceFake);

        return $subscriptionServiceFake;
    }
}
