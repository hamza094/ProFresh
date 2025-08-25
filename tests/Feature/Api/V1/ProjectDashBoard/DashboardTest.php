<?php

namespace Tests\Feature\Api\V1;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Traits\ProjectSetup;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardTest extends TestCase
{
    use RefreshDatabase, ProjectSetup;

    /** @test */
    public function auth_user_can_view_dashboard_projects()
    {
        // Create 5 projects for the user
        Project::factory()->count(5)->for($this->user)->create();

        $response = $this->getJson('/api/v1/user/dashboard-projects');

        $response->assertOk()
            ->assertJsonStructure([
                'projects',
                'projectsCount',
                'message'
            ]);

        // Should only return 3 projects (latest)
        $this->assertCount(3, $response->json('projects'));
        $this->assertEquals(3, $response->json('projectsCount'));
        $this->assertNotEmpty($response->json('projects'));
    }

    /** @test */
    public function dashboard_projects_returns_empty_message_when_no_projects()
    {
        // Delete the default project from ProjectSetup trait
        $this->project->delete();

        $response = $this->getJson('/api/v1/user/dashboard-projects');

        $response->assertOk();

        $this->assertCount(0, $response->json('projects'));
        $this->assertEquals(0, $response->json('projectsCount'));
        $this->assertEquals('No active projects found', $response->json('message'));
    }
    
}
