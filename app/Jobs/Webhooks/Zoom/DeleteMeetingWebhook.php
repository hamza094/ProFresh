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

    public $meeting_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public $tries = 2;

    public function __construct(array $data)
    {
        $this->meeting_id = $data['meeting_id'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        try {
            $meeting = Meeting::where('meeting_id', $this->meeting_id)->firstOrFail();

            $meeting->delete();

            Log::channel('webhook')->info('Meeting deleted successfully', ['meeting_id' => $this->meeting_id]);
        } catch (ModelNotFoundException $e) {
            Log::channel('webhook')->info('Meeting not available in database', ['meeting_id' => $this->meeting_id]);
            
            throw new ModelNotFoundException('Meeting not available in database', 0, $e);
        }
    }

    public function failed(\Exception $exception)
    {
        Log::channel('webhook')->error('Delete Meeting webhook job failed', [
            'error' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString()
        ]);
    }

    public function backoff(): array
    {
      return [5, 30];
    }
}
