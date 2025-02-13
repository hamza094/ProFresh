<?php

namespace App\Events;

use App\Models\Conversation;
use App\Models\Project;
use App\Http\Resources\Api\V1\ConversationResource;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DeleteConversation implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets,SerializesModels;

    public int $conversationId;
    public string $projectSlug;


    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(int $conversationId, string $projectSlug)
    {
       $this->conversationId = $conversationId;
       $this->projectSlug = $projectSlug;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
      return new PrivateChannel('deleteConversation.'.$this->projectSlug);
    }

    public function broadcastWith()
    {
      return [
            'conversation_id' => $this->conversationId
        ];
    }
}
