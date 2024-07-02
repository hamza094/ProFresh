<?php

namespace App\Jobs\Webhooks\Zoom;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Meeting;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;

class DeleteMeetingWebhook implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $payload;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $payload)
    {
        $this->payload = $payload;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $meetingId = $this->payload['object']['id'];

        try {

        $meeting = Meeting::where('meeting_id', $meetingId)->firstOrFail();

          $meeting->delete();

        Log::channel('webhook')->info('Meeting deleted successfully', ['meeting_id' => $meetingId]);

       } catch (ModelNotFoundException $e) {

        Log::channel('webhook')->info('Meeting not available in database', ['meeting_id' => $meetingId]);

        throw new ModelNotFoundException('Meeting not available in database', 0, $e);

}

    }
}
