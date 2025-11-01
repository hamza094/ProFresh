<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Jobs\Webhooks\Zoom;

use App\Events\MeetingStatusUpdate;
use App\Jobs\Webhooks\Zoom\MeetingEndsWebhook;
use App\Models\Meeting;
use App\Models\User;
use App\Notifications\Zoom\MeetingEnded;
use App\Traits\ProjectSetup;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class EndedMeetingWebhookTest extends TestCase
{
    use ProjectSetup,RefreshDatabase;

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

        $users = User::factory()->count(2)->create()->each(fn ($user) => $this->inviteAndActivateUser($this->project, $user)
        );

        $fixture = File::json(
            path: base_path('tests/Fixtures/Webhooks/Zoom/meeting_ended.json'),
            flags: JSON_THROW_ON_ERROR,
        );

        $object = $fixture['payload']['object'];
        $meetingId = (string) $object['id'];
        $startTime = $object['start_time'] ?? null;
        $endTime = $object['end_time'] ?? null;

        $job = new MeetingEndsWebhook([
            'meeting_id' => $meetingId,
            'start_time' => $startTime,
            'end_time' => $endTime,
        ]);

        $job->handle();

        $this->assertEquals('ended', $meeting->fresh()->status);

        Event::assertDispatched(fn (MeetingStatusUpdate $event) => $event->meeting->id === $meeting->id);

        Notification::assertSentTo($users, MeetingEnded::class, fn ($notification, $channels) => $channels === ['mail', 'database', 'broadcast']);
    }

    private function inviteAndActivateUser($project, $user)
    {
        $project->invite($user);
        $project->members()->updateExistingPivot($user->id, ['active' => true]);
    }
}
