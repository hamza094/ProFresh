<?php

declare(strict_types=1);

namespace App\Services\Api\V1\Paddle;

use App\Interfaces\Paddle;
use App\Models\User;

final class SubscriptionServiceFake implements Paddle
{
    public function subscribe(User $user, string $plan): mixed
    {
        return 'https://fake-paylink-url.com';
    }

    /**
     * @return array{message: string}
     */
    public function swap(User $user, string $plan): array
    {
        return [
            'message' => 'Your subscription has been successfully updated to the '.$plan.' plan (fake).',
        ];
    }

    /**
     * @return array{message: string}
     */
    public function cancel(User $user, string $plan): array
    {
        return [
            'message' => 'Your subscription has been canceled successfully (fake).',
        ];
    }
}
