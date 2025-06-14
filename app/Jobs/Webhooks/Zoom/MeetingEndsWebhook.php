<?php

namespace App\Jobs\Webhooks\Zoom;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Notifications\Zoom\MeetingEnded;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;
use Illuminate\Support\Facades\Notification;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Events\MeetingStatusUpdate;
use Illuminate\Support\Facades\Log;
use App\Enums\MeetingState;
use App\Models\Meeting;
use Carbon\Carbon;

class MeetingEndsWebhook implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $meeting_id;
    public ?string $start_time;
    public ?string $end_time;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $data)
    {
        $this->meeting_id = $data['meeting_id'];
        $this->start_time = $data['start_time'] ?? null;
        $this->end_time = $data['end_time'] ?? null;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $meeting = $this->getMeeting();

            if (!$this->validateStatus($meeting)) {
                return;
            }

            $this->updateMeetingStatus($meeting);
            $this->sendNotifications($meeting);
        } catch (ModelNotFoundException $e) {
            Log::channel('webhook')->error("Meeting with ID {$this->meeting_id} not found in the database.");
            throw $e;
        } catch (\Exception $e) {
            Log::channel('webhook')->error("Error processing meeting ending webhook: " . $e->getMessage(), ['exception' => $e]);
            throw $e;
        }
    }

    private function getMeeting(): Meeting
    {
        return Meeting::where('meeting_id', $this->meeting_id)->firstOrFail();
    }

    private function updateMeetingStatus(Meeting $meeting): void
    {
        $meeting->update(['status' => MeetingState::ENDS->value]);
        event(new MeetingStatusUpdate($meeting));
    }

    private function sendNotifications(Meeting $meeting): void
    {
        $project = $meeting->project()->with(['asignees','user'])->firstOrFail();
        $user = $project->user;
        $members = $project->asignees;

        $notificationData = [
            'project_name' => $project->name,
            'project_slug' => $project->slug,
            'project_path' => $project->path(),
            'meeting_topic' => $meeting->topic,
            'meeting_timezone' => $meeting->timezone,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'notifier' => $user->getNotifierData(),
        ];

        Notification::send($members, new MeetingEnded($notificationData));
    }

    private function validateStatus($meeting): bool
    {
        if ($meeting->status === MeetingState::ENDS->value) {
            Log::channel('webhook')->info("Meeting already ended for meeting_id: {$this->meeting_id}");
            return false;
        }
        return true;
    }

    public function failed(Throwable $exception)
    {
        Log::error('Meeting Ended webhook job failed', [
            'meeting_id' => $this->meeting_id,
            'error' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString(),
        ]);
    }
}
