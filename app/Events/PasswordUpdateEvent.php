<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PasswordUpdateEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The user whose password was updated.
     */
    public User $user;

    /**
     * The time the password was updated.
     */
    public string $updatedAt;

    /**
     * Create a new event instance.
     */
    public function __construct(User $user, string $updatedAt)
    {
        $this->user = $user;
        $this->updatedAt = $updatedAt;
    }
}
