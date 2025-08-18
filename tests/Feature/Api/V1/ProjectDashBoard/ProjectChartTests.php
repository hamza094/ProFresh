<?php

namespace Tests\Feature\Api\V1\ProjectDashboard;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Traits\ProjectSetup;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectChartTests extends TestCase
{
    use RefreshDatabase, ProjectSetup;

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
