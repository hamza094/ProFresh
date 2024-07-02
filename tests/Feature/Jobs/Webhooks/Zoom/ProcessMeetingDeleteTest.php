<?php

namespace Tests\Feature\Jobs\Webhooks\Zoom;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Jobs\Webhooks\Zoom\DeleteMeetingWebhook;
use App\Models\Meeting;
use Illuminate\Support\Facades\Exceptions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProcessMeetingDeleteTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */


    /** @test */
    public function zoom_meeting_can_be_deleted()
    {
        $meeting=Meeting::factory()->create([
          'meeting_id'=>813,
        ]);

        $payload = [
        'account_id' => 'HsTKzp8YTIWubRtgF7L_2w',
        'operator' => 'test_operator@example.com',
        'operator_id' => 'tWcCtVTiTum7Ctdx1p0GWQ',
        'object' => [
            'id' => 813,
            'type' => 0
        ],
    ];  

        $job = new DeleteMeetingWebhook(payload: $payload);

        $job->handle();

         $this->assertModelMissing($meeting);

    }

    /** @test */
    public function throw_exception_if_meeting_not_found()
    {
        $meeting=Meeting::factory()->create([
          'meeting_id'=>813,
        ]);

        $payload = [
        'account_id' => 'HsTKzp8YTIWubRtgF7L_2w',
        'operator' => 'test_operator@example.com',
        'operator_id' => 'tWcCtVTiTum7Ctdx1p0GWQ',
        'object' => [
            'id' => 313,
            'type' => 0
        ],
    ];  

        $job = new DeleteMeetingWebhook(payload: $payload);

        $this->assertDatabaseHas('meetings', [
        'meeting_id' => 813,
        ]);

       $this->assertThrows(
        fn() => $job->handle(),
        \Illuminate\Database\Eloquent\ModelNotFoundException::class
    );

    }
}
