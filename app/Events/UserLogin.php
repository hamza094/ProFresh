<?php

declare(strict_types=1);

namespace App\Events;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;

class UserLogin // implements ShouldQueue
{
    use Dispatchable;

    /**
     * The user instance.
     *
     * @var User
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
