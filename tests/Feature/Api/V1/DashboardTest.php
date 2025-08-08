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
    public function auth_user_view_his_activities()
    {
      $response = $this->getJson('api/v1/user/activities')->assertOk();

      $response->assertJsonFragment(['user_id' => $this->user->id]);
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
    
    /** @test */
    public function auth_user_can_get_chart_data()
    {
        // Create projects with different dates for testing
        Project::factory()->create([
            'user_id' => $this->user->id,
            'created_at' => now()->subMonth()
        ]);

        Project::factory()->create([
            'user_id' => $this->user->id,
            'created_at' => now()
        ]);

        // Create a trashed project
        Project::factory()->create([
            'user_id' => $this->user->id,
            'deleted_at' => now()
        ]);

        // Create a project where user is a member
        $memberProject = Project::factory()->create();
        DB::table('project_members')->insert([
            'project_id' => $memberProject->id,
            'user_id' => $this->user->id,
            'active' => 1,
        ]);

        $response = $this->getJson('/api/v1/dashboard/chart-data');

        $response->assertOk()
            ->assertJsonStructure([
                'active_projects',
                'trashed_projects', 
                'member_projects',
                'total_projects'
            ]);

        $data = $response->json();
        $this->assertIsInt($data['active_projects']);
        $this->assertIsInt($data['trashed_projects']);
        $this->assertIsInt($data['member_projects']);
        $this->assertIsInt($data['total_projects']);
        $this->assertEquals(
            $data['active_projects'] + $data['trashed_projects'] + $data['member_projects'],
            $data['total_projects']
        );
    }

    /** @test */
    public function chart_data_respects_year_month_filters()
    {
        // Arrange
        $currentYear = now()->year;
        $currentMonth = now()->month;
        $previousYear = $currentYear - 1;

        // Delete the default project from ProjectSetup trait to start clean
        $this->project->delete();

        // Create project in current year/month
        Project::factory()->create([
            'user_id' => $this->user->id,
            'created_at' => now()
        ]);

        // Create project in previous year
        Project::factory()->create([
            'user_id' => $this->user->id,
            'created_at' => Carbon::create($previousYear, 6, 15)
        ]);

        // Act & Assert
        // 1. Current year filter
        $currentYearResponse = $this->getJson("/api/v1/dashboard/chart-data?year={$currentYear}");
        $this->assertEquals(1, $currentYearResponse->json('active_projects'));

        // 2. Previous year filter
        $previousYearResponse = $this->getJson("/api/v1/dashboard/chart-data?year={$previousYear}");
        $this->assertEquals(1, $previousYearResponse->json('active_projects'));

        // 3. Current year and month filter
        $monthFilterResponse = $this->getJson("/api/v1/dashboard/chart-data?year={$currentYear}&month={$currentMonth}");
        $this->assertEquals(1, $monthFilterResponse->json('active_projects'));

        // 4. No filters
        $noFilterResponse = $this->getJson("/api/v1/dashboard/chart-data");
        $this->assertEquals(2, $noFilterResponse->json('active_projects'));

        // Assert all responses were successful
        collect([
            $currentYearResponse,
            $previousYearResponse,
            $monthFilterResponse,
            $noFilterResponse
        ])->each->assertOk();
    }

}
