<?php

namespace App\Jobs\Webhooks\Zoom;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Notifications\Zoom\MeetingStarted;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;
use Throwable;
use App\Enums\MeetingState;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Events\MeetingStatusUpdate;
use App\Models\Meeting;

class StartMeetingWebhook implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $meetingId;
    private string $startTime;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $payload)
    {
        $this->meetingId = $payload['object']['id'];
        $this->startTime = $payload['object']['start_time'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try{

            $meeting = $this->getMeeting();

            $this->validateStatus($meeting);
            $this->updateMeetingStatus($meeting);
            $this->sendNotifications($meeting);

        } catch (ModelNotFoundException $e) {
        Log::channel('webhook')->error("Meeting with ID {$this->meetingId} not found in the database.");
            throw $e;

    } catch (\Exception $e) {
      Log::channel('webhook')->error("Error processing meeting starting webhook: " . $e->getMessage(), ['exception' => $e]);
       throw $e;
    }
    }

    private function getMeeting(): Meeting
    {
       return Meeting::where('meeting_id', $this->meetingId)->firstOrFail();
    }

    private function updateMeetingStatus(Meeting $meeting): void
    {
        $meeting->update(['status' => MeetingState::START->value]);

        event(new MeetingStatusUpdate($meeting));
    }

    private function sendNotifications(Meeting $meeting): void
    {
        $project = $meeting->project()->with('asignees')->firstOrFail();

        $user= $meeting->project->user;

        $members = $project->asignees;

        Notification::send($members, new MeetingStarted($project, $meeting, $this->startTime, $user));
    }

    private function validateStatus($meeting)
    {
       if($meeting->status === MeetingState::START->value){
            return Log::channel('webhook')->info("Meeting already started for meeting_id: {$this->meetingId}");
        }
    }

    public function failed(Throwable $exception)
    {
        Log::error('Meeting Started webhook job failed', [
            'meeting_id' => $this->meetingId,
            'error' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString(),
        ]);
    }



}
