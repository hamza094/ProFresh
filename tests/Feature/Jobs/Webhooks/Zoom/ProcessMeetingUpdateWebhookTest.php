<?php

namespace Tests\Feature\Jobs\Webhooks\Zoom;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Meeting;
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

           $payload = [
        'account_id' => 'HsTKzp8YTIWubRtgF7L_2w',
        'operator' => 'test_operator@example.com',
        'operator_id' => 'tWcCtVTiTum7Ctdx1p0GWQ',
        'object' => [
            'id' => 813,
            'topic' => 'eye to eye like sky'
        ],
        'old_object' => [
            'id' => 813,
            'topic' => 'shining in the sky'
        ]
    ]; 

        $job = new UpdateMeetingWebhook(payload: $payload);

        $job->handle();

        $this->assertSame(
            expected: $job->payload['object']['topic'],
            actual: $meeting->fresh()->topic,
        );
    }
}
