<?php

namespace Tests\Feature\Api\Controllers\Zoom;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Exceptions\Integrations\Zoom\ZoomException;
use Tests\Traits\InteractsWithZoom;
use App\Traits\ProjectSetup;
use Carbon\Carbon;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use InteractsWithZoom,ProjectSetup,RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    /** @test */
    public function meeting_can_be_created_successfully()
    {
        $zoomFake = $this->fakeZoom();

      $postBody = [
        'topic' => 'test-repo',
        'agenda' => 'test-description',
        'duration' => 30,
        'password' => "metingpass",
        'join_before_host'=>false,
        'start_time'=>Carbon::now()->addWeek(),
        'timezone'=>'UTC'
      ];

      $response=$this->withoutExceptionHandling()->postJson(route('meetings.store',['project'=>$this->project->slug]), $postBody);

      $meetingResponse=$response->json()['meeting'];

       $zoomFake->assertMeetingCreated(
           topic: $postBody['topic'],
           agenda: $postBody['agenda'],
           duration: $postBody['duration'],
        );

        $this->assertDatabaseHas('meetings',['topic'=>$meetingResponse['topic']]);
    }

    /** @test */
  public function user_get_exception_if_error_occurs(): void
 {
    $postBody = [
        'topic' => 'test-repo',
        'agenda' => 'test-description',
        'duration' => 30,
        'password' => "metingpass",
        'join_before_host'=>false,
        'start_time'=>Carbon::now()->addWeek(),
        'timezone'=>'UTC'
      ];

      $zoomFake = $this->fakeZoom()->shouldFailWithException(
         new ZoomException('Test error message')
        );

     $response=$this->postJson(route('meetings.store',['project'=>$this->project->slug]), $postBody);
      
    $zoomFake->assertNoMeetingsCreated();

    $response->assertBadRequest();
 }

   /** @test */
    public function it_validates_meeting_creation_request()
    {
        $postBody = [
            'topic' => '',
            'agenda' => '',
            'duration' => 'not-an-integer',
            'password' => '',
            'join_before_host' => 'not-a-boolean',
            'start_time' => Carbon::now()->subWeek(),
            'timezone' => 'invalid/timezone',
        ];

         $response=$this->postJson(route('meetings.store',['project'=>$this->project->slug]), $postBody);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors([
            'topic',
            'agenda',
            'duration',
            'password',
            'join_before_host',
            'start_time',
            'timezone',
        ]);
    }
   
}
