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
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Events\MeetingStatusUpdate;
use Illuminate\Support\Facades\Log;
use App\Models\Meeting;
use Carbon\Carbon;

class MeetingEndsWebhook implements ShouldQueue
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
            'project.activeMembers',
          ])
           ->where('meeting_id', $meetingId)
           ->firstOrFail();

           if($meeting->status == 'ended'){
            return Log::channel('webhook')->info('Meeting notification already sent');
           }

            $project = $meeting->project;

            $activeMembers = $project->activeMembers;

            $start_time = $this->payload['object']['start_time'];

            $end_time = $this->payload['object']['end_time'];

           $endAt = Carbon::parse($end_time)->format('F j, Y g:i A');

            $user = $project->user()->select('id', 'name')->first();

            $meeting->update(['status' => 'ended']);

            event(new MeetingStatusUpdate($meeting));

            foreach($activeMembers as $member){
             $member->notify(new MeetingEnded($project,$meeting,$start_time,$endAt,$user));
            }

            Log::channel('webhook')->info('Meeting ended notifications sent successfully', ['meeting_id' => $meetingId]);

        } catch (ModelNotFoundException $e) {

        Log::channel('webhook')->info('Meeting not found', ['meeting_id' => $meetingId]);

    } catch (\Exception $e) {

        Log::channel('webhook')->error('Error processing meeting ending webhook', [
            'meeting_id' => $meetingId,
            'error' => $e->getMessage(),
        ]);

    }
    }

    public function failed(Throwable $exception)
    {
        Log::channel('webhook')->error('Meeting Ended webhook job failed', [
            'error' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString()
        ]);
    }
}
