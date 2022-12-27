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
use Illuminate\Queue\SerializesModels;

class NewMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

     public $conversation;
     public $project;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Conversation $conversation,Project $project)
    {
        $this->conversation = $conversation;
        $this->project = $project;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */

    public function broadcastOn()
    {
      return new PrivateChannel('conversations.'.$this->project->slug);
    }

    public function broadcastWith()
    {
      return (new ConversationResource($this->conversation))
              ->resolve();
    }
}
