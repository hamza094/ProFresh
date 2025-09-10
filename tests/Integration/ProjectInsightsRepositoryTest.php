<?php

namespace Tests\Integration;

use Tests\TestCase;
use App\Repository\ProjectInsightsRepository;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Models\Activity;
use App\Enums\ProjectStage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

class ProjectInsightsRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private ProjectInsightsRepository $repository;
    private Project $project;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->repository = app(ProjectInsightsRepository::class);
        $this->project = Project::factory()->create(['stage' => ProjectStage::EXECUTION]);
        
        // Create test data
        $this->createTestData();
    }

    /** @test */
    public function loads_all_data_in_optimized_single_query(): void
    {
        // Enable query logging
        DB::enableQueryLog();
        
        // Execute the repository method
        $metrics = $this->repository->getProjectInsights($this->project, ['all']);
        
        // Get executed queries
        $queries = DB::getQueryLog();
        DB::disableQueryLog();
        
        // Should use minimal queries (ideally 1-2: one for counts, maybe one for complex relationships)
        $this->assertLessThanOrEqual(2, count($queries), 'Repository should use optimized query strategy');
        
        // Verify the main query includes multiple count relationships
        $mainQuery = $queries[0]['query'] ?? '';
        $this->assertStringContainsString('count', strtolower($mainQuery), 'Should use count aggregations');
        
        // Verify metrics DTO is properly populated
        $this->assertNotNull($metrics);
        $this->assertNotNull($metrics->health);
        $this->assertNotNull($metrics->completionRate);
        $this->assertNotNull($metrics->overdueCount);
    }

    /** @test */
    public function conditionally_loads_data_based_on_sections(): void
    {
        DB::enableQueryLog();
        
        // Request only completion metrics
        $metrics = $this->repository->getProjectInsights($this->project, ['completion']);
        
        $queries = DB::getQueryLog();
        DB::disableQueryLog();
        
        // Should still be optimized
        $this->assertLessThanOrEqual(2, count($queries));
        
        // Should have completion data but null for unused sections
        $this->assertNotNull($metrics->completionRate);
        $this->assertNull($metrics->teamEngagement); // Not requested
        $this->assertEquals(75.0, $metrics->completionRate); // 3 of 4 tasks completed
    }

    /** @test */
    public function handles_empty_project_efficiently(): void
    {
        $emptyProject = Project::factory()->create();
        
        DB::enableQueryLog();
        $metrics = $this->repository->getProjectInsights($emptyProject, ['all']);
        $queries = DB::getQueryLog();
        DB::disableQueryLog();
        
        // Should still be efficient even with no data
        $this->assertLessThanOrEqual(2, count($queries));
        
        // Should return DTO with appropriate null/zero values
        $this->assertNotNull($metrics);
        $this->assertEquals(0.0, $metrics->completionRate);
        $this->assertEquals(0, $metrics->overdueCount);
    }

    /** @test */
    public function calculates_completion_rate_correctly(): void
    {
        $metrics = $this->repository->getProjectInsights($this->project, ['completion']);
        
        // Should calculate 75% (3 completed out of 4 total tasks)
        $this->assertEquals(75.0, $metrics->completionRate);
    }

    /** @test */
    public function counts_overdue_tasks_correctly(): void
    {
        $metrics = $this->repository->getProjectInsights($this->project, ['overdue']);
        
        // Should count 1 overdue task
        $this->assertEquals(1, $metrics->overdueCount);
    }

    /** @test */
    public function executes_actions_with_proper_data(): void
    {
        $metrics = $this->repository->getProjectInsights($this->project, ['health', 'engagement']);
        
        // Health action should execute and return a score
        $this->assertIsFloat($metrics->health);
        $this->assertGreaterThanOrEqual(0, $metrics->health);
        $this->assertLessThanOrEqual(100, $metrics->health);
        
        // Engagement action should execute
        $this->assertIsFloat($metrics->teamEngagement);
        $this->assertGreaterThanOrEqual(0, $metrics->teamEngagement);
    }

    /** @test */
    public function handles_section_dependencies_correctly(): void
    {
        // Health section depends on multiple data sources
        DB::enableQueryLog();
        $metrics = $this->repository->getProjectInsights($this->project, ['health']);
        $queries = DB::getQueryLog();
        DB::disableQueryLog();
        
        // Should load all necessary counts for health calculation
        $this->assertNotNull($metrics->health);
        $this->assertLessThanOrEqual(2, count($queries));
        
        // The health calculation should have access to all required data
        $this->assertGreaterThan(0, $metrics->health);
    }

    /** @test */
    public function removes_duplicate_counts_efficiently(): void
    {
        // Request sections that share common data sources
        DB::enableQueryLog();
        $metrics = $this->repository->getProjectInsights($this->project, ['health', 'completion', 'engagement']);
        $queries = DB::getQueryLog();
        DB::disableQueryLog();
        
        // Should not duplicate common counts (like task counts)
        $this->assertLessThanOrEqual(2, count($queries));
        
        // All requested metrics should be populated
        $this->assertNotNull($metrics->health);
        $this->assertNotNull($metrics->completionRate);
        $this->assertNotNull($metrics->teamEngagement);
    }

    /** @test */
    public function uses_config_values_in_time_filters(): void
    {
        // Set custom config for recent activity days
        config(['project-metrics.time_periods.recent_activity_days' => 14]);
        
        $metrics = $this->repository->getProjectInsights($this->project, ['health']);
        
        // Should use config value (activities within 14 days should be counted)
        $this->assertNotNull($metrics->health);
        $this->assertGreaterThan(0, $metrics->health);
    }

    /** @test */
    public function handles_null_relationships_gracefully(): void
    {
        // Create project with no relationships
        $isolatedProject = Project::factory()->create();
        
        $metrics = $this->repository->getProjectInsights($isolatedProject, ['all']);
        
        // Should not crash and return appropriate defaults
        $this->assertNotNull($metrics);
        $this->assertEquals(0.0, $metrics->completionRate);
        $this->assertEquals(0, $metrics->overdueCount);
        $this->assertEquals(0.0, $metrics->health);
    }

    /** @test */
    public function maintains_data_consistency_across_multiple_calls(): void
    {
        // Make multiple calls with same parameters
        $metrics1 = $this->repository->getProjectInsights($this->project, ['completion']);
        $metrics2 = $this->repository->getProjectInsights($this->project, ['completion']);
        
        // Results should be consistent
        $this->assertEquals($metrics1->completionRate, $metrics2->completionRate);
        $this->assertEquals($metrics1->overdueCount, $metrics2->overdueCount);
    }

    private function createTestData(): void
    {
        // Create tasks with specific distribution for predictable testing
        Task::factory()->count(3)->create([
            'project_id' => $this->project->id,
            'status' => 'completed',
            'updated_at' => now()->subDays(2)
        ]);
        
        Task::factory()->create([
            'project_id' => $this->project->id,
            'status' => 'pending',
            'due_date' => now()->addDays(5),
            'updated_at' => now()->subDays(1)
        ]);
        
        // One overdue task
        Task::factory()->create([
            'project_id' => $this->project->id,
            'status' => 'pending',
            'due_date' => now()->subDays(1)
        ]);
        
        // Add project members
        $users = User::factory()->count(3)->create();
        $this->project->members()->attach($users->pluck('id'));
        
        // Add recent activities
        Activity::factory()->count(5)->create([
            'project_id' => $this->project->id,
            'created_at' => now()->subDays(3)
        ]);
    }
}
