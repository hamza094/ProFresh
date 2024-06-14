<?php

namespace Tests\Feature\Controllers\Zoom;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Exceptions\Integrations\Zoom\ZoomException;
use Tests\Traits\InteractsWithZoom;
use App\Models\Meeting;
use App\Traits\ProjectSetup;
use Tests\TestCase;

class DeleteMeetingTest extends TestCase
{
    use RefreshDatabase,InteractsWithZoom,ProjectSetup;
   
    /** @test */
    public function meeting_can_be_deleted()
    {
        $zoomFake = $this->fakeZoom();

        $meeting=Meeting::factory()
               ->for($this->project)
               ->create(['user_id'=>$this->user->id]);

        $meetingId=$meeting->id;
        
        $this->withoutExceptionHandling()->deleteJson('/api/v1/projects/'.$this->project->slug.'/meetings/'.$meeting->id);

         $this->assertModelMissing($meeting);
    }

        /** @test */
public function database_changes_are_rolled_back_if_meeting_delete_fails()
{
    $meeting = Meeting::factory()
        ->for($this->project)
        ->create(['user_id' => $this->user->id]);

    $meetingId = $meeting->id;

    $zoomFake = $this->fakeZoom()->shouldFailWithException(
         new ZoomException('Test error message')
        );

     $response=$this->withoutExceptionHandling()->deleteJson('/api/v1/projects/'.$this->project->slug.'/meetings/'.$meeting->id);

    $response->assertStatus(400);

    $this->assertDatabaseHas('meetings', [
        'id' => $meetingId,
    ]);
}
}
