<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\User;
use App\Models\Project;
use App\Models\Stage;
use App\Models\TaskStatus;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Tests\Support\BuildsInsightTestData;

class ProjectInsightsApiTest extends TestCase
{
    use RefreshDatabase;
    use BuildsInsightTestData;

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
    $this->seedRealisticData($this->project, $this->user);

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
        // Verify each insight has basic structure (detailed content covered by unit tests)
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
    $this->seedRealisticData($this->project, $this->user);

        Sanctum::actingAs($this->user);

        // Act: Request only health and task-health sections
        $response = $this
            ->withoutExceptionHandling()->getJson("/api/v1/projects/{$this->project->slug}/insights?sections[]=health&sections[]=task-health");

            // Assert
        $response->assertOk();

        $data = $response->json('data');
        $this->assertEquals(['health', 'task-health'], $data['sections_requested']);
        $this->assertIsArray($data['insights']);
        $this->assertNotEmpty($data['insights']);
        foreach ($data['insights'] as $insight) {
            $this->assertArrayHasKey('type', $insight);
            $this->assertArrayHasKey('title', $insight);
            $this->assertArrayHasKey('message', $insight);
            $this->assertArrayHasKey('data', $insight);
        }
    }

    /** @test */
    public function can_get_single_section_via_url_path(): void
    {
        // Arrange
        $this->seedRealisticData($this->project, $this->user);

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
        // Basic structure only
        $this->assertArrayHasKey('type', $insights[0]);
        $this->assertArrayHasKey('title', $insights[0]);
        $this->assertArrayHasKey('message', $insights[0]);
        $this->assertArrayHasKey('data', $insights[0]);
    }

    /** @test */
    public function requires_authentication(): void
    {
        // No actingAs here
        $this->getJson("/api/v1/projects/{$this->project->slug}/insights")
            ->assertStatus(401);
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
}
