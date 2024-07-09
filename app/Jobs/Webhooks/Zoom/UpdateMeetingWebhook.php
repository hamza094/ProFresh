<?php

namespace App\Jobs\Webhooks\Zoom;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use App\Models\Meeting;

class UpdateMeetingWebhook implements ShouldQueue
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
        $updateData = $this->payload['object'];
        unset($updateData['id'], $updateData['uuid']);

        $meeting = Meeting::where('meeting_id', $meetingId)->first();

        if ($meeting) {
                $isUpdated = $this->isMeetingUpdated($meeting, $updateData);

                if ($isUpdated) {
                    $meeting->update($updateData);
                    Log::channel('webhook')->info('Meeting updated via webhook', ['meeting_id' => $meetingId]);
                } else {
                    Log::channel('webhook')->info('Same data nothing to update', ['meeting_id' => $meetingId]);
                }
        } else {
            Log::channel('webhook')->warning('Meeting not found', ['meeting_id' => $meetingId]);
        }
    }

    private function isMeetingUpdated($meeting, $updateData)
    {
        foreach ($updateData as $key => $value) {
            if ($meeting->$key != $value) {
                return true;
            }
        }
        return false;
    }

    public function failed(\Exception $exception)
    {
        Log::channel('webhook')->error('Update Meeting webhook job failed', [
            'error' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString()
        ]);
    }

    public function backoff(): array
    {
      return [5, 30];
    }
}
