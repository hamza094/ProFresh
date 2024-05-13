<?php

namespace Tests\Feature\Controllers\Zoom;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\Test;
use App\Collections\Meeting\MeetingCollection;
use App\DataTransferObjects\Meeting\NewMeetingData;
use App\DataTransferObjects\Zoom\Meeting;
use App\Exceptions\Integrations\Zoom\MeetingException;
use Tests\Traits\InteractsWithZoom;
use App\Traits\ProjectSetup;
use Tests\TestCase;

class ZoomMeetingTest extends TestCase
{
     use RefreshDatabase;
     use InteractsWithZoom;
     use ProjectSetup;

    /** @test */
    public function meetings_can_be_created(): void
    {
        $zoomFake = $this->fakeZoom();

      $postBody = [
        'id' => 1234,
        'topic' => 'topic of meeting',
        'agenda' => 'this is the agenda of meeting',
        'password' => 'herpku',
        'joinBeforeHost'=>false,
      ];

      $response=$this->withoutExceptionHandling()->postJson(route('zoom.meetings.store'), $postBody);

     $response->assertStatus(201) 
    ->assertJson([
        'message' => 'Meeting Created Successfully',
        'meeting' =>  $postBody, 
    ]);


       /*$zoomFake->assertMeetingCreated(
           id: $postBody['id'],
           topic: $postBody['topic'],
           agenda: $postBody['agenda'],
        );*/
  }

}
