<?php

namespace Tests\Feature\Api\Jobs\Webhooks\Zoom;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Meeting;
use App\Traits\ProjectSetup;
use Illuminate\Support\Facades\File;
use App\Jobs\Webhooks\Zoom\StartMeetingWebhook;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Zoom\MeetingStarted;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use App\Events\MeetingStatusUpdate;
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
        Event::fake();

        $meeting = Meeting::factory()->create([
            'meeting_id' => 813,
            'project_id' => $this->project->id,
            'user_id' => $this->user->id,
        ]);

        $users = User::factory()->count(2)->create()->each(fn($user) =>
            $this->inviteAndActivateUser($this->project, $user)
        );

        $fixture = File::json(
            path: base_path('tests/Fixtures/Webhooks/Zoom/meeting_start.json'),
            flags: JSON_THROW_ON_ERROR,
        );

        $payload = $fixture['payload'];
        $object = $payload['object'];
        $meetingId = $object['id'];
        $startTime = $object['start_time'] ?? null;

        $job = new StartMeetingWebhook([
            'meeting_id' => $meetingId,
            'start_time' => $startTime,
        ]);

        $job->handle();

        $this->assertEquals('started', $meeting->fresh()->status);

        Event::assertDispatched(function (MeetingStatusUpdate $event) use ($meeting) {
            return $event->meeting->id === $meeting->id;
        });

        Notification::assertSentTo($users, MeetingStarted::class, function ($notification, $channels) {
            return $channels === ['mail', 'database', 'broadcast'];
        });
    }

    private function inviteAndActivateUser($project, $user)
    {
        $project->invite($user);
        $project->members()->updateExistingPivot($user->id, ['active' => true]);
    }
}
