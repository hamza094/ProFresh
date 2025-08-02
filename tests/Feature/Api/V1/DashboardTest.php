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

class DashboardTest extends TestCase
{
    use RefreshDatabase, ProjectSetup;

    /** @test */
    public function auth_user_view_his_activities()
    {
        $response = $this->getJson('api/v1/user/activities')->assertOk();

      $response->assertJsonFragment(['user_id' => $this->user->id]);
    }

    /** @test */
    public function auth_user_get_his_projects_count()
    {
        Project::factory()->create(['user_id' => $this->user->id]);

        Project::factory()->create(['deleted_at' => now(), 'user_id' => $this->user->id]);

        $invitedProject = Project::factory()->create();

        DB::table('project_members')->insert([
            'project_id' => $invitedProject->id,
            'user_id' => $this->user->id,
            'active' => 1,
        ]);
        
        $response = $this->getJson('api/v1/data')->assertOk();

        $projectsData = $response->json('projectsData');
         
        $this->assertEquals(2, $projectsData['active_projects']);

        $this->assertEquals(1, $projectsData['trashed_projects']);

        $this->assertEquals(1, $projectsData['active_invited_projects']);

        $this->assertEquals(
         array_sum(array_only($projectsData, ['active_projects', 'trashed_projects', 'active_invited_projects'])),
            $projectsData['total_projects']
        );
    }

    /** @test */
    public function auth_user_view_his_related_tasks()
    {
      Task::factory(['user_id' => $this->user->id, 'project_id' => $this->project->id])->count(3)->create();

    $randomUser = User::factory()->create();

    $task2 = Task::factory(['user_id' => $randomUser->id])->create();

    $task2->assignee()->attach($this->user);

    $response = $this->getJson('api/v1/tasksdata?task_assigned=true&user_created=true');

    $responseData = $response->json();

    $this->assertEquals(['Filter by Created', 'Filter by Assigned'], $responseData['applied_filters']);

    $this->assertCount(4, $responseData['tasks']);

    $this->assertEquals($task2->title, $responseData['tasks'][3]['title']);
    }

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
