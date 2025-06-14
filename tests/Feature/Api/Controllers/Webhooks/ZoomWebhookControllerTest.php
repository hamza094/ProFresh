<?php

namespace Tests\Feature\Api\Controllers\Webhooks;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use App\Models\Meeting;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Queue;
use App\Jobs\Webhooks\Zoom\UpdateMeetingWebhook;
use App\Jobs\Webhooks\Zoom\DeleteMeetingWebhook;
use App\Jobs\Webhooks\Zoom\StartMeetingWebhook;
use App\Jobs\Webhooks\Zoom\MeetingEndsWebhook;
use Carbon\Carbon;
use Tests\TestCase;
use Mockery;

class ZoomWebhookControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    protected function setUp(): void
    {
      parent::setUp();

      $this->travelTo(Carbon::parse('2024-06-24 11:49:48'));

     Queue::fake([
        UpdateMeetingWebhook::class,
        DeleteMeetingWebhook::class,
        StartMeetingWebhook::class,
        MeetingEndsWebhook::class,
    ]);
     
    }
    
    /** @test */
    public function meeting_can_be_updated_via_webhook()
    {
        $this->withoutMiddleware([\App\Http\Middleware\VerifyZoomWebhook::class]);

        $meeting = Meeting::factory()->create([
            'meeting_id' => 813,
            'topic' => 'shining in the sky'
        ]);

        $postBody = File::json(
            path: base_path('tests/Fixtures/Webhooks/Zoom/meeting_update.json'),
            flags: JSON_THROW_ON_ERROR,
        );

        $object = $postBody['payload']['object'];
        $meetingId = $object['id'];
        $updateData = collect($object)->except(['id', 'uuid'])->toArray();

        $response = $this->post(route('webhooks.meetings.update'), $postBody)
            ->assertOk()
            ->assertExactJson(['status' => 'success']);

        Queue::assertPushed(UpdateMeetingWebhook::class, function ($job) use ($meetingId, $updateData) {
            return $job->meeting_id === $meetingId && $job->update_data === $updateData;
        });
    }

    /** @test */
    public function meeting_can_be_deleted()
    {
        $this->withoutMiddleware([\App\Http\Middleware\VerifyZoomWebhook::class]);

        $meeting = Meeting::factory()->create([
            'meeting_id' => 813,
        ]);

        $postBody = File::json(
            path: base_path('tests/Fixtures/Webhooks/Zoom/meeting_delete.json'),
            flags: JSON_THROW_ON_ERROR,
        );

        $object = $postBody['payload']['object'];
        $meetingId = $object['id'];

        $response = $this->post(route('webhooks.meetings.delete'), $postBody)
            ->assertOk()
            ->assertExactJson(['status' => 'success']);

        Queue::assertPushed(DeleteMeetingWebhook::class, function ($job) use ($meetingId) {
            return $job->meeting_id === $meetingId;
        });
    }

    /** @test */
    public function zoom_meeting_can_be_started()
    {
        $this->withoutMiddleware([\App\Http\Middleware\VerifyZoomWebhook::class]);

        $meeting = Meeting::factory()->create([
            'meeting_id' => 813,
        ]);

        $postBody = File::json(
            path: base_path('tests/Fixtures/Webhooks/Zoom/meeting_start.json'),
            flags: JSON_THROW_ON_ERROR,
        );


        $object = $postBody['payload']['object'];
        $meetingId = $object['id'];
        $startTime = $object['start_time'] ?? null;

        $response = $this->post(route('webhooks.meetings.start'), $postBody)
            ->assertOk()
            ->assertExactJson(['status' => 'success']);

        Queue::assertPushed(StartMeetingWebhook::class, function ($job) use ($meetingId, $startTime) {
            return $job->meeting_id === (string)$meetingId && $job->start_time === $startTime;
        });
    }
 
    /** @test */
    public function zoom_meeting_can_be_ended()
    {
        $this->withoutMiddleware([\App\Http\Middleware\VerifyZoomWebhook::class]);

        $meeting = Meeting::factory()->create([
            'meeting_id' => 813,
        ]);

        $postBody = File::json(
            path: base_path('tests/Fixtures/Webhooks/Zoom/meeting_ended.json'),
            flags: JSON_THROW_ON_ERROR,
        );

        $object = $postBody['payload']['object'];
        $meetingId = $object['id'];
        $startTime = $object['start_time'] ?? null;
        $endTime = $object['end_time'] ?? null;


        $response = $this->post(route('webhooks.meetings.ended'), $postBody)
            ->assertOk()
            ->assertExactJson(['status' => 'success']);



        Queue::assertPushed(MeetingEndsWebhook::class, function ($job) use ($meetingId, $startTime, $endTime) {
            return $job->meeting_id === (string)$meetingId && $job->start_time === $startTime && $job->end_time === $endTime;
        });

    }
    
    /** @test */
    public function error_is_returned_if_the_request_was_not_sent_from_zoom()
   {
    $response=$this->post(route('webhooks.meetings.update'),['invalid_key' => 'invalid_value'])->assertForbidden();

     Queue::assertNothingPushed();
   }

}
