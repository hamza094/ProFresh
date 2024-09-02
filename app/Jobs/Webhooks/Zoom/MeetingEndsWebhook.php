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

    private $meetingId;
    private $startTime;
    private $endTime;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $payload)
    {
        $this->meetingId = $payload['object']['id'];
        $this->startTime = $payload['object']['start_time'];
        $this->endTime = $payload['object']['end_time'];
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
        Log::channel('webhook')->error("Error processing meeting ending webhook: " . $e->getMessage(), ['exception' => $e]);
       throw $e;
    }
    }

    private function getMeeting(): Meeting
    {
        return Meeting::where('meeting_id', $this->meetingId)->firstOrFail();
    }

    private function validateStatus($meeting)
    {
       if($meeting->status === MeetingState::ENDS->value){
            return Log::channel('webhook')->info("Meeting already ended for meeting_id: {$this->meetingId}");
        }
    }

    private function updateMeetingStatus(Meeting $meeting): void
    {
        $meeting->update(['status' => MeetingState::ENDS->value]);

        event(new MeetingStatusUpdate($meeting));
    }

    private function sendNotifications(Meeting $meeting): void
    {
        $project = $meeting->project()->with('asignees')->firstOrFail();

        $user= $meeting->project->user;

        $members = $project->asignees;

        $endAt = Carbon::parse($this->endTime)->format('F j, Y g:i A');

        Notification::send($members, new MeetingEnded($project,$meeting,$this->startTime,$endAt,$user));
    }

    public function failed(Throwable $exception)
    {
        Log::error('Meeting Ended webhook job failed', [
            'meeting_id' => $this->meetingId,
            'error' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString(),
        ]);
    }
}
