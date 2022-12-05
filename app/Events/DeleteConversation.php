<?php

namespace App\Events;

use App\Models\Conversation;
use App\Models\Project;
use App\Http\Resources\ConversationResource;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
//use Illuminate\Queue\SerializesModels;

class DeleteConversation implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets;// SerializesModels;

    public $conversation;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Conversation $conversation)
    {
       $this->conversation = $conversation;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
      return new Channel('deleteConversation');
    }

    public function broadcastWith()
    {
      return (new ConversationResource($this->conversation))
              ->resolve();
    }
}
