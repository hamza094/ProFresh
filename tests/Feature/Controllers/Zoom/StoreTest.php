<?php

namespace Tests\Feature\Controllers\Zoom;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Exceptions\Integrations\Zoom\ZoomException;
use Tests\Traits\InteractsWithZoom;
use App\Traits\ProjectSetup;

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
    public function meeting_can_be_created_in_zoom()
    {
        $zoomFake = $this->fakeZoom();

      $postBody = [
        'topic' => 'test-repo',
        'agenda' => 'test-description',
        'duration' => 30,
        'password' => "metingpass",
        'joinBeforeHost'=>false,
      ];

      $response=$this->postJson(route('meetings.store',['project'=>$this->project->slug]), $postBody);

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
    $zoomFake = $this->fakeZoom()->shouldFailWithException(
         new ZoomException('Test error message')
        );

    $postBody = [
        'topic' => 'test-repo',
        'agenda' => 'test-description',
        'duration' => 30,
        'password' => "meting password",
        'joinBeforeHost'=>false,
    ];

     $response=$this->postJson(route('meetings.store',['project'=>$this->project->slug]), $postBody);
      
    $zoomFake->assertNoMeetingsCreated();

    $response->assertBadRequest();
 }
   
}
