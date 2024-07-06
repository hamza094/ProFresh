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
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Meeting;

class StartMeetingWebhook implements ShouldQueue
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

        try{
           $meeting = Meeting::query()->with([
            'project:id,name,slug',
            'project.activeMembers'
          ])
           ->where('meeting_id', $meetingId)
           ->firstOrFail();

            $project = $meeting->project;

            $activeMembers = $project->activeMembers;

            $start_time = $this->payload['object']['start_time'];

            $user = $project->user()->select('uuid', 'name');

            $notification = new MeetingStarted($project,$meeting,$start_time,$user);

            $activeMembers->each->notify($notification);

            Log::channel('webhook')->info('Meeting notifications sent successfully', ['meeting_id' => $meetingId]);

        } catch (ModelNotFoundException $e) {

        Log::channel('webhook')->info('Meeting not found', ['meeting_id' => $meetingId]);

    } catch (\Exception $e) {

        Log::channel('webhook')->error('Error processing meeting started webhook', [
            'meeting_id' => $meetingId,
            'error' => $e->getMessage(),
        ]);

    }
    }
}
