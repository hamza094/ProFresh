<?php

namespace Tests\Feature\Jobs\Webhooks\Zoom;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Meeting;
use App\Traits\ProjectSetup;
use Illuminate\Support\Facades\File;
use App\Jobs\Webhooks\Zoom\StartMeetingWebhook;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Zoom\MeetingStarted;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StartMeetingWebhookTest extends TestCase
{
    use RefreshDatabase,ProjectSetup;

    /**
     * A basic feature test example.
     *
     * @return void
     */

    /** @test */
    public function notifies_project_members_on_meeting_start()
    {
        Notification::fake();

        $meeting=Meeting::factory()->create([
          'meeting_id'=>813,
          'project_id'=>$this->project->id,
          'user_id'=>$this->user->id,
        ]);

        $user=User::factory()->create();

        $user1=User::factory()->create();

        $this->inviteAndActivateUser($this->project, $user);
        $this->inviteAndActivateUser($this->project, $user1);

         $fixture = File::json(
        path: base_path('tests/Fixtures/Webhooks/Zoom/meeting_start.json'),
        flags: JSON_THROW_ON_ERROR,
    );

        $payload = $fixture['payload'];  

        $job = new StartMeetingWebhook(payload: $payload);

        $job->handle();

    Notification::assertSentTo(
        [$user, $user1],
        MeetingStarted::class,
        function (MeetingStarted $notification, $channels) use ($job) {
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
