<?php

namespace Tests\Feature\Controllers\Webhooks;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use App\Models\Meeting;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Queue;
use App\Jobs\Webhooks\Zoom\UpdateMeetingWebhook;
use Carbon\Carbon;
use Tests\TestCase;
use Mockery;

class ZoomControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    protected function setUp(): void
    {
      parent::setUp();

      $this->travelTo(Carbon::parse('2024-06-24 11:49:48'));

     Queue::fake([UpdateMeetingWebhook::class]);
    }
    
    /** @test */
    public function meeting_can_be_updated()
    {

    $this->withoutMiddleware([\App\Http\Middleware\VerifyZoomWebhook::class]);

        $meeting=Meeting::factory()->create([
          'meeting_id'=>813,
          'topic'=>'shining in the sky'
        ]);

        $postBody = File::json(
           path: base_path('tests/Fixtures/Webhooks/Zoom/meeting_update.json'),
           flags: JSON_THROW_ON_ERROR,
        );

        $response=$this->post(route('webhooks.meetings.update'),
         $postBody)
            ->assertOk()
            ->assertExactJson(['status' => 'success']);

         Queue::assertPushed(UpdateMeetingWebhook::class, function ($job) use ($postBody) {
        return $job->payload == $postBody['payload'];
    });
    }
 
    
    /** @test */
    public function error_is_returned_if_the_request_was_not_sent_from_zoom()
   {
    $response=$this->post(route('webhooks.meetings.update'),['invalid_key' => 'invalid_value'])->assertForbidden();

     Queue::assertNothingPushed();
 }

}
