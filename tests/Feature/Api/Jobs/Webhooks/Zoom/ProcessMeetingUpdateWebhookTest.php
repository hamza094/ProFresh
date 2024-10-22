<?php

namespace Tests\Feature\Api\Jobs\Webhooks\Zoom;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Meeting;
use Illuminate\Support\Facades\File;
use App\Jobs\Webhooks\Zoom\UpdateMeetingWebhook;
use Tests\TestCase;

class ProcessMeetingUpdateWebhookTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    /** @test */
    public function zoom_meeting_can_be_updated()
    {
        $meeting=Meeting::factory()->create([
          'meeting_id'=>813,
          'topic'=>'shining in the sky'
        ]);

        $fixture = File::json(
        path: base_path('tests/Fixtures/Webhooks/Zoom/meeting_update.json'),
        flags: JSON_THROW_ON_ERROR,
    );

        $payload = $fixture['payload'];  

        $job = new UpdateMeetingWebhook(payload: $payload);

        $job->handle();

        $this->assertSame(
            expected: $job->payload['object']['topic'],
            actual: $meeting->fresh()->topic,
        );
    }
}
