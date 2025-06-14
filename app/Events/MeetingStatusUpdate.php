<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Http\Resources\Api\V1\Zoom\MeetingsResource;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Meeting;

class MeetingStatusUpdate implements ShouldBroadcast
{
    public $meeting;

    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Meeting $meeting)
    {
        $this->meeting=$meeting;

    }

    public function broadcastOn()
    {
       return new PrivateChannel('meetingStatus.'.$this->meeting->id);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastWith()
    {
        return (new MeetingsResource($this->meeting))
              ->resolve();
    }
}
