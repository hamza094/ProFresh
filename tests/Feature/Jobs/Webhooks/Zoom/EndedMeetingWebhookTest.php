<?php

namespace Tests\Feature\Jobs\Webhooks\Zoom;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Meeting;
use App\Traits\ProjectSetup;
use Illuminate\Support\Facades\File;
use App\Jobs\Webhooks\Zoom\MeetingEndsWebhook;
use Illuminate\Support\Facades\Event;
use App\Events\Zoom\MeetingStatusUpdate;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Zoom\MeetingEnded;

class EndedMeetingWebhookTest extends TestCase
{
    use RefreshDatabase,ProjectSetup;
    
    /** @test */
    public function notifies_project_members_on_meeting_ended()
    {
        Notification::fake();
        Event::fake();

        $meeting=Meeting::factory()->create([
          'meeting_id'=>813,
          'project_id'=>$this->project->id,
          'user_id'=>$this->user->id,
          'status'=>'waiting',
        ]);

        $user=User::factory()->create();

        $user1=User::factory()->create();

        $this->inviteAndActivateUser($this->project, $user);
        $this->inviteAndActivateUser($this->project, $user1);

         $fixture = File::json(
        path: base_path('tests/Fixtures/Webhooks/Zoom/meeting_ended.json'),
        flags: JSON_THROW_ON_ERROR,
    );

        $payload = $fixture['payload'];  

        $job = new MeetingEndsWebhook(payload: $payload);

        $job->handle();

    $this->assertEquals('ended', $meeting->fresh()->status);

    Event::assertDispatched(function (MeetingStatusUpdate $event) use ($meeting) {
    return $event->meeting->id === $meeting->id;
  });

    Notification::assertSentTo(
        [$user, $user1],
        MeetingEnded::class,
        function (MeetingEnded $notification, $channels) use ($job) {
            return $notification->meeting->meeting_id === $job->payload['object']['id']
                && in_array('mail', $channels)
                && in_array('database', $channels)
                && in_array('broadcast', $channels);
        }
    );

    }

    private function inviteAndActivateUser($project, $user)
    {
        $project->invite($user);
        $project->members()->updateExistingPivot($user->id, ['active' => true]);
    }
}
