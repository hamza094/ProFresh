<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PasswordUpdateEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The user whose password was updated.
     *
     * @var \App\Models\User
     */
    public User $user;

    /**
     * The time the password was updated.
     *
     * @var string
     */
    public string $updatedAt;

    /**
     * Create a new event instance.
     *
     * @param \App\Models\User $user
     * @param string $updatedAt
     */
    public function __construct(User $user, string $updatedAt)
    {
        $this->user = $user;
        $this->updatedAt = $updatedAt;
    }
}
