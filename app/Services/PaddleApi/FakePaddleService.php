<?php

namespace App\Services\Paddle;

use App\Collections\Paddle\DataCollection;
use App\DataTransferObjects\Paddle\UserSubscriptionData;
use App\Interfaces\Paddle;

class FakePaddleService implements Paddle
{
    public function subscriptionUsersList(UserSubscriptionData $subscriptionData): DataCollection
    {
        // Return a fake DataCollection for testing purposes
        return new DataCollection([
            [
                'id' => 1,
                'name' => 'Test User',
                'email' => 'testuser@example.com',
                'plan' => 'monthly',
            ],
        ]);
    }
}