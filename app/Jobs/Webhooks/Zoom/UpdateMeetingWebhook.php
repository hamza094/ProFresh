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

    /**
     * @var int|string
     */
    public $meeting_id;

    /**
     * @var array<string, mixed>
     */
    public $update_data;

    /**
     * @param array<string, mixed> $data
     * @return void
     */
    public function __construct(array $data)
    {
        $this->meeting_id = $data['meeting_id'];
        $this->update_data = $data['update_data'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $meeting = Meeting::where('meeting_id', $this->meeting_id)->first();

    if (!$meeting) {
        Log::channel('webhook')->warning('Meeting not found', ['meeting_id' => $this->meeting_id]);
        return;
    }

    if ($this->isMeetingUpdated($meeting, $this->update_data)) {
        $meeting->update($this->update_data);
        Log::channel('webhook')->info('Meeting updated via webhook', ['meeting_id' => $this->meeting_id]);
    } else {
        Log::channel('webhook')->info('Same data nothing to update', ['meeting_id' => $this->meeting_id]);
    }
}

    /**
     * @param \App\Models\Meeting $meeting
     * @param array<string, mixed> $updateData
     */
    private function isMeetingUpdated(\App\Models\Meeting $meeting, array $updateData): bool
    {
        foreach ($updateData as $key => $value) {
            if ($meeting->$key !== $value) {
                return true;
            }
        }
        return false;
    }

    public function failed(\Exception $exception): void
    {
        Log::channel('webhook')->error('Update Meeting webhook job failed', [
            'error' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString()
        ]);
    }

    /**
     * @return array<int, int>
     */
    public function backoff(): array
    {
      return [5, 30];
    }
}
