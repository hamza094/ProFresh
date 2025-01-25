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

class NewMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

     public Conversation $conversation;
     public int $projectId;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Conversation $conversation,int $projectId)
    {
        $this->conversation = $conversation;
        $this->projectId = $projectId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */

    public function broadcastOn(): PrivateChannel
    {
      return new PrivateChannel('project'.$this->projectId.'conversations');
    }
 
    /**
    * Get the data to broadcast.
    *
    * @return array<string, mixed>
    */
    public function broadcastWith(): array
    {
      return (new ConversationResource($this->conversation))
              ->resolve();
    }
}
