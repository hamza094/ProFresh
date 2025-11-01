<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Jobs\Webhooks\Zoom;

use App\Jobs\Webhooks\Zoom\UpdateMeetingWebhook;
use App\Models\Meeting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class ProcessMeetingUpdateWebhookTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     *

    /** @test */
    public function zoom_meeting_can_be_updated()
    {
        $meeting = Meeting::factory()->create([
            'meeting_id' => 813,
            'topic' => 'shining in the sky',
        ]);

        $fixture = File::json(
            path: base_path('tests/Fixtures/Webhooks/Zoom/meeting_update.json'),
            flags: JSON_THROW_ON_ERROR,
        );

        $object = $fixture['payload']['object'];
        $meetingId = $object['id'];
        $updateData = collect($object)->except(['id', 'uuid'])->toArray();

        $job = new UpdateMeetingWebhook([
            'meeting_id' => $meetingId,
            'update_data' => $updateData,
        ]);

        $job->handle();

        $this->assertSame(
            expected: $updateData['topic'],
            actual: $meeting->fresh()->topic,
        );
    }
}
