<?php

namespace Tests\Feature\Api\V1;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Project;
use App\Models\Meeting;
use App\Traits\ProjectSetup;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

class MeetingTest extends TestCase
{
    use LazilyRefreshDatabase, ProjectSetup;

    /** @test */
    public function it_can_show_a_meeting()
    {
        $meeting = Meeting::factory()->for($this->project)->for($this->user)->create();

        $this->actingAs($this->user);

        $response = $this->getJson("/api/v1/projects/{$this->project->slug}/meetings/{$meeting->id}");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'id' => $meeting->id,
                    'meeting_id' => $meeting->meeting_id,  
                ]
            ]);
    }

    /** @test */
    public function it_can_list_meetings_for_a_project()
    {
        $this->actingAs($this->user);
        // Create 5 meetings: 3 scheduled, 2 previous
        $scheduledMeetings = Meeting::factory()->count(3)->for($this->project)->for($this->user)->create([
            'start_time' => now()->addDays(1),
        ]);
        $previousMeetings = Meeting::factory()->count(2)->for($this->project)->for($this->user)->create([
            'start_time' => now()->subDays(1),
        ]);

        // Scheduled meetings (default)
        $response = $this->getJson("/api/v1/projects/{$this->project->slug}/meetings");
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Scheduled meetings',
            ]);
            
        $this->assertCount(3, $response->json('meetingsData.data'));

        // Previous meetings
        $response = $this->getJson("/api/v1/projects/{$this->project->slug}/meetings?request=previous");
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Previous meetings',
            ]);

        $this->assertCount(2, $response->json('meetingsData.data'));
    }
}
