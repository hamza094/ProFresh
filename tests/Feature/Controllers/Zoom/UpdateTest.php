<?php

namespace Tests\Feature\Controllers\Zoom;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Exceptions\Integrations\Zoom\ZoomException;
use App\Http\Integrations\Zoom\Requests\UpdateMeeting;
use Tests\Traits\InteractsWithZoom;
use App\Models\Meeting;
use App\Traits\ProjectSetup;
use Tests\TestCase;

class UpdateTest extends TestCase
{
   use ProjectSetup,RefreshDatabase,InteractsWithZoom;
    
    /** @test */
    public function meeting_in_database_can_be_updated()
    {
        $zoomFake = $this->fakeZoom();

        $meeting=Meeting::factory()
               ->for($this->project)
               ->create(['user_id'=>$this->user->id]);

    $updatedMeetingID=18976;
    $updatedDuration=15;

     $this->withoutExceptionHandling()->postJson('/api/v1/projects/'.$this->project->slug.'/meetings/'.$meeting->id.'/update', [
        'meeting_id'=>$updatedMeetingID,
      'duration' => $updatedDuration,
    ]);

     $meeting->refresh();

      $this->assertDatabaseHas('meetings',[
      'duration'=>$updatedDuration,
      'meeting_id'=>$updatedMeetingID,
    ]);

    }

    /** @test */
public function database_changes_are_rolled_back_if_zoom_update_fails()
{
    $meeting = Meeting::factory()
        ->for($this->project)
        ->create(['user_id' => $this->user->id]);

    $updatedMeetingID = 18976;
    $updatedDuration = 15;

    $zoomFake = $this->fakeZoom()->shouldFailWithException(
         new ZoomException('Test error message')
        );

    $response = $this->postJson('/api/v1/projects/' . $this->project->slug . '/meetings/' . $meeting->id . '/update', [
        'meeting_id' => $updatedMeetingID,
        'duration' => $updatedDuration,
    ]);

    $response->assertStatus(400);
    $meeting->refresh();

    $this->assertDatabaseMissing('meetings', [
        'duration' => $updatedDuration,
        'meeting_id' => $updatedMeetingID,
    ]);
}

  /** @test */
  public function it_validates_update_request()
  {
    $meeting = Meeting::factory()
        ->for($this->project)
        ->create(['user_id' => $this->user->id]);

    $response = $this->postJson('/api/v1/projects/' . $this->project->slug . '/meetings/' . $meeting->id . '/update', [
        'meeting_id' => 'not-an-integer',
    ]);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['meeting_id']);
  }


}
