<?php

namespace Tests\Feature\Api\Jobs\Webhooks\Zoom;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Jobs\Webhooks\Zoom\DeleteMeetingWebhook;
use App\Models\Meeting;
use Illuminate\Support\Facades\Exceptions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\File;
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

         $fixture = File::json(
        path: base_path('tests/Fixtures/Webhooks/Zoom/meeting_delete.json'),
        flags: JSON_THROW_ON_ERROR,
    );

        $payload = $fixture['payload'];  

        $job = new DeleteMeetingWebhook(payload: $payload);

        $job->handle();

         $this->assertModelMissing($meeting);

    }

    /** @test */
    public function throw_exception_if_meeting_not_found()
    {
        $meeting=Meeting::factory()->create([
          'meeting_id'=>413,
        ]);

       $fixture = File::json(
        path: base_path('tests/Fixtures/Webhooks/Zoom/meeting_delete.json'),
        flags: JSON_THROW_ON_ERROR,
    );

        $payload = $fixture['payload'];  

        $job = new DeleteMeetingWebhook(payload: $payload);

        $this->assertDatabaseHas('meetings', [
        'meeting_id' => 413,
        ]);

       $this->assertThrows(
        fn() => $job->handle(),
        \Illuminate\Database\Eloquent\ModelNotFoundException::class
    );

    }
}
