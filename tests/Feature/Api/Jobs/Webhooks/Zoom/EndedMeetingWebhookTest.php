<?php

namespace Tests\Feature\Api\Jobs\Webhooks\Zoom;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Meeting;
use App\Traits\ProjectSetup;
use Illuminate\Support\Facades\File;
use App\Jobs\Webhooks\Zoom\MeetingEndsWebhook;
use Illuminate\Support\Facades\Event;
use App\Events\MeetingStatusUpdate;
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

        $meeting = Meeting::factory()->create([
            'meeting_id' => 813,
            'project_id' => $this->project->id,
            'user_id' => $this->user->id,
            'status' => 'waiting',
        ]);

        $users = User::factory()->count(2)->create()->each(fn($user) =>
            $this->inviteAndActivateUser($this->project, $user)
        );

        $fixture = File::json(
            path: base_path('tests/Fixtures/Webhooks/Zoom/meeting_ended.json'),
            flags: JSON_THROW_ON_ERROR,
        );

        $object = $fixture['payload']['object'];
        $meetingId = (string)$object['id'];
        $startTime = $object['start_time'] ?? null;
        $endTime = $object['end_time'] ?? null;

        $job = new MeetingEndsWebhook([
            'meeting_id' => $meetingId,
            'start_time' => $startTime,
            'end_time' => $endTime,
        ]);

        $job->handle();

        $this->assertEquals('ended', $meeting->fresh()->status);

        Event::assertDispatched(function (MeetingStatusUpdate $event) use ($meeting) {
            return $event->meeting->id === $meeting->id;
        });

        Notification::assertSentTo($users, MeetingEnded::class, function ($notification, $channels) {
            return $channels === ['mail', 'database', 'broadcast'];
        });
    }

    private function inviteAndActivateUser($project, $user)
    {
        $project->invite($user);
        $project->members()->updateExistingPivot($user->id, ['active' => true]);
    }
}
