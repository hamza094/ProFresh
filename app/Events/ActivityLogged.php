<?php

namespace App\Events;

use App\Models\Activity;
use Illuminate\Broadcasting\Channel;
use App\Http\Resources\Api\V1\ActivityResource;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ActivityLogged implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Activity $activity;
    public int $projectId;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Activity $activity,int $projectId)
    {
       $this->activity = $activity;
      $this->projectId = $projectId;
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): Channel
    {
       return new Channel('activities/project/'.$this->projectId);
    }


     /**
     * Get the data to broadcast.
     * 
     * @return array<string, int>
     */
    public function broadcastWith(): array
    {
       return (new ActivityResource($this->activity))->resolve();
    }
}
