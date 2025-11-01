<?php

declare(strict_types=1);

namespace App\Interfaces;

use App\Models\User;

interface Paddle
{
    public function subscribe(User $user, string $plan): mixed;

    /**
     * @return array{message: string}
     */
    public function swap(User $user, string $plan): array;

    /**
     * @return array{message: string}
     */
    public function cancel(User $user, string $plan): array;
}
