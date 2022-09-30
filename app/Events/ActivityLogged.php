<?php

namespace App\Events;

use App\Models\Activity;
use App\Http\Resources\ActivityResource;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ActivityLogged implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $activity;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Activity $activity)
    {
       $this->activity = $activity;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
       return new Channel('activity');
    }

    public function broadcastWith()
    {
       return (new ActivityResource($this->activity))->resolve();
    }
}
