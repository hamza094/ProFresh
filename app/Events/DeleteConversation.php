<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DeleteConversation implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets,SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(public int $conversationId, public string $projectSlug) {}

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('deleteConversation.'.$this->projectSlug);
    }

    /**
     * Get the data to broadcast.
     *
     * @return array<string, int>
     */
    public function broadcastWith(): array
    {
        return [
            'conversation_id' => $this->conversationId,
        ];
    }
}
