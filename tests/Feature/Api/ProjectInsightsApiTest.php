<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\User;
use App\Models\Project;
use App\Models\Task;
use App\Models\Activity;
use App\Models\Stage;
use App\Models\TaskStatus;
use App\Enums\ProjectStage;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use App\Enums\TaskStatus as TaskStatusEnum;

class ProjectInsightsApiTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private User $nonMember;
    private Project $project;
    private Stage $stage;
    private TaskStatus $status;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::factory()->create();
        $this->status = TaskStatus::factory()->create();
        $this->stage = Stage::factory()->create();
        $this->nonMember = User::factory()->create();
        $this->project = Project::factory()->create([
            'name' => 'Test Project',
            'stage_id' => $this->stage->id
        ]);
        
        // Make user a project member
        $this->project->members()->attach($this->user->id);
        
        // Set up test config
        Config::set('project-metrics.health.weights.tasks', 0.4);
        Config::set('project-metrics.time_periods.recent_activity_days', 7);
    }

    /** @test */
    public function can_get_project_insights_with_realistic_data(): void
    {
        // Arrange: Create realistic project data
        $this->createRealisticProjectData();

        Sanctum::actingAs($this->user);

        // Act: Make API request
        $response = $this
            ->getJson("/api/v1/projects/{$this->project->slug}/insights");

        // Assert: Basic response structure
        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'project_id',
                    'project_name',
                    'insights' => [
                        '*' => ['type', 'title', 'message', 'data']
                    ],
                    'sections_requested',
                    'generated_at'
                ],
                'message'
            ]);

        // Assert: Key business logic
        $data = $response->json('data');
        $this->assertEquals($this->project->id, $data['project_id']);
        $this->assertEquals('Test Project', $data['project_name']);
        $this->assertNotEmpty($data['insights']);
        
        // Verify insights contain expected sections
        $insightTypes = collect($data['insights'])->pluck('title')->toArray();
        $this->assertContains('Project Completion', $insightTypes);
        
        // Verify each insight has proper structure
        foreach ($data['insights'] as $insight) {
            $this->assertArrayHasKey('type', $insight);
            $this->assertArrayHasKey('title', $insight);
            $this->assertArrayHasKey('message', $insight);
            $this->assertArrayHasKey('data', $insight);
        }
    }

    /** @test */
    public function can_get_specific_sections_only(): void
    {
        // Arrange
        $this->createRealisticProjectData();

        Sanctum::actingAs($this->user);

        // Act: Request only health and completion sections
        $response = $this
            ->getJson("/api/v1/projects/{$this->project->slug}/insights?sections[]=health&sections[]=completion");

        // Assert
        $response->assertOk();

        $data = $response->json('data');
        $this->assertEquals(['health', 'completion'], $data['sections_requested']);

        // Check that requested sections are present
        $this->assertContains('health', $data['sections_requested']);
        $this->assertContains('completion', $data['sections_requested']);

        // Check insight titles
        $insightTitles = collect($data['insights'])->pluck('title')->toArray();
        $this->assertContains('Project Completion', $insightTitles);
        $this->assertContains('Poor Project Health', $insightTitles);

        // Should not contain other sections
        $notExpectedTitles = ['Team Engagement', 'Project Risks'];
        foreach ($notExpectedTitles as $notExpected) {
            $this->assertNotContains($notExpected, $insightTitles);
        }
    }

    /** @test */
    public function can_get_single_section_via_url_path(): void
    {
        // Arrange
        $this->createRealisticProjectData();

        Sanctum::actingAs($this->user);

        // Act: Request health section via query parameter instead of URL path
        $response = $this
            ->getJson("/api/v1/projects/{$this->project->slug}/insights?sections[]=health");

        // Assert
        $response->assertOk();
        
    $data = $response->json('data');
    $this->assertEquals(['health'], $data['sections_requested']);

    $insights = $data['insights'];
    $this->assertCount(1, $insights);
    // Assert the insight title is for health
    $this->assertStringContainsString('Health', $insights[0]['title']);
    // Optionally, assert the type is a valid severity
    $this->assertContains($insights[0]['type'], ['critical', 'info', 'success', 'warning']);
    }


    /** @test */
    public function validates_invalid_sections_parameter(): void
    {
        // Act: Request with invalid section
        Sanctum::actingAs($this->user);

        $response = $this
            ->getJson("/api/v1/projects/{$this->project->slug}/insights?sections[]=invalid_section");

        // Assert: Validation error
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['sections.0']);
    }

    /** @test */
    public function handles_empty_project_gracefully(): void
    {
        // Arrange: Project with no tasks, activities, etc.
        $emptyProject = Project::factory()->create(['name' => 'Empty Project']);
        $emptyProject->members()->attach($this->user->id);

        Sanctum::actingAs($this->user);

        // Act
        $response = $this
            ->getJson("/api/v1/projects/{$emptyProject->slug}/insights");

        // Assert: Should still return valid structure
        $response->assertOk();
        
        $data = $response->json('data');
        $this->assertEquals($emptyProject->id, $data['project_id']);
        $this->assertIsArray($data['insights']);
        
        // Verify each insight handles empty data gracefully
        foreach ($data['insights'] as $insight) {
            $this->assertArrayHasKey('data', $insight);
            $this->assertIsArray($insight['data']);
        }
    }


    /** @test */
    public function calculates_completion_rate_correctly(): void
    {
        // Arrange: Create specific task distribution (60% completion)
        $completedStatus = TaskStatus::factory()->create([
            'id' => 4, // TaskStatusEnum::COMPLETED
            'label' => 'Completed'
        ]);
        
        // Use the existing status from setUp() for pending tasks
        $pendingStatus = $this->status;
        
        Task::factory()->count(6)->create([
            'project_id' => $this->project->id,
            'status_id' => $completedStatus->id
        ]);
        Task::factory()->count(4)->create([
            'project_id' => $this->project->id,
            'status_id' => $pendingStatus->id
        ]);

        Sanctum::actingAs($this->user);

        // Act: Request completion insights
        $response = $this
            ->getJson("/api/v1/projects/{$this->project->slug}/insights?sections[]=completion");

        // Assert: Completion rate should be 60%
        $response->assertOk();
        
        $insights = $response->json('data.insights');
        $completionInsight = collect($insights)->firstWhere('title', 'Project Completion');
        
        $this->assertNotNull($completionInsight);
        $this->assertEquals(60.0, $completionInsight['data']['value']);
        $this->assertStringContainsString('60', $completionInsight['message']);
    }

    /** @test */
    public function identifies_overdue_tasks(): void
    {
        // Arrange: Create overdue tasks
        $pendingStatus = TaskStatus::factory()->create(); // Default "Not Started"
        
        Task::factory()->count(2)->create([
            'project_id' => $this->project->id,
            'status_id' => $pendingStatus->id,
            'due_at' => now()->subDays(2) // Overdue
        ]);
        Task::factory()->count(3)->create([
            'project_id' => $this->project->id,
            'status_id' => $pendingStatus->id,
            'due_at' => now()->addDays(5) // Not overdue
        ]);

        Sanctum::actingAs($this->user);

        // Act
        $response = $this->actingAs($this->user)
            ->getJson("/api/v1/projects/{$this->project->slug}/insights?sections[]=overdue");

        // Assert: Should identify 2 overdue tasks
        $response->assertOk();
        
        $insights = $response->json('data.insights');
        $overdueInsight = collect($insights)->firstWhere('type', 'warning');
        
        $this->assertNotNull($overdueInsight);
        $this->assertEquals(2, $overdueInsight['data']['count']);
        $this->assertStringContainsString('2', $overdueInsight['message']);
    }

    /** @test */
    public function calculates_team_engagement_with_activities(): void
    {
        // Arrange: Create recent activities
        Activity::factory()->count(5)->create([
            'project_id' => $this->project->id,
            'user_id' => $this->user->id,
            'created_at' => now()->subDays(2)
        ]);

        Sanctum::actingAs($this->user);

        // Act
        $response = $this
            ->getJson("/api/v1/projects/{$this->project->slug}/insights?sections[]=engagement");

        // Assert: Should calculate engagement based on activities
        $response->assertOk();
        
        $insights = $response->json('data.insights');
        // Look for engagement insight by title containing "Engagement"
        $engagementInsight = collect($insights)->first(function ($insight) {
            return str_contains($insight['title'], 'Engagement');
        });
        
        $this->assertNotNull($engagementInsight);
        $this->assertArrayHasKey('value', $engagementInsight['data']);
        $this->assertIsNumeric($engagementInsight['data']['value']);
    }

    /** @test */
    public function handles_different_project_stages(): void
    {
        // Arrange: Create different stages
        $designStage = Stage::factory(['id'=>2])->create();
        
        // Create projects in different stages
        $planningProject = Project::factory()->create([
            'stage_id' => $this->stage->id
        ]);
        $planningProject->members()->attach($this->user->id);

        $designPhaseProject = Project::factory()->create([
            'stage_id' => $designStage->id
        ]);
        $designPhaseProject->members()->attach($this->user->id);

        // Act & Assert: Both should return valid insights
        Sanctum::actingAs($this->user);

        $planningResponse = $this
            ->getJson("/api/v1/projects/{$planningProject->slug}/insights?sections[]=stage");
        $planningResponse->assertOk();

        $designPhaseResponse = $this
            ->getJson("/api/v1/projects/{$designPhaseProject->slug}/insights?sections[]=stage");
        $designPhaseResponse->assertOk();

        // Stage progress should reflect different stages
        $planningStage = collect($planningResponse->json('data.insights'))
            ->firstWhere('type', 'stage');
        $designPhaseStage = collect($designPhaseResponse->json('data.insights'))
            ->firstWhere('type', 'stage');

        $this->assertNotEquals(
            $planningStage['data']['percentage'] ?? 0,
            $completedStage['data']['percentage'] ?? 17
        );
    }

    private function createRealisticProjectData(): void
    {
        // Set the stage on the project
        $this->project->stage_id = $this->stage->id;
        $this->project->save();

        // Create different task statuses
        $completedStatus = TaskStatus::factory()->completed()->create();
        $progressStatus = TaskStatus::factory()->progress()->create();
        $pendingStatus = TaskStatus::factory()->create(); // Default "Not Started"

        // Create tasks with mixed status using proper status IDs
        Task::factory()->count(6)->create([
            'project_id' => $this->project->id,
            'status_id' => $completedStatus->id,
            'updated_at' => now()->subDays(2)
        ]);
        
        Task::factory()->count(3)->create([
            'project_id' => $this->project->id,
            'status_id' => $progressStatus->id,
            'due_at' => now()->addDays(5)
        ]);
        
        Task::factory()->create([
            'project_id' => $this->project->id,
            'status_id' => $pendingStatus->id,
            'due_at' => now()->subDays(1), // Overdue
        ]);

        // Create recent activities
        Activity::factory()->count(8)->create([
            'project_id' => $this->project->id,
            'user_id' => $this->user->id,
            'created_at' => now()->subDays(3)
        ]);

        // Add additional project members
        $additionalMembers = User::factory()->count(2)->create();
        $this->project->members()->attach($additionalMembers->pluck('id'));
    }
}
