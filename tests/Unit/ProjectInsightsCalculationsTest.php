<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Actions\ProjectMetrics\ProjectHealthMetricAction;
use App\Actions\ProjectMetrics\TaskHealthMetricAction;
use App\Actions\ProjectMetrics\TeamCollaborationMetricAction;
use App\Actions\ProjectMetrics\StageProgressMetricAction;
use App\Actions\ProjectMetrics\UpcomingRiskMetricAction;
use App\Models\Project;
use App\Enums\ProjectStage;
use Mockery;

class ProjectInsightsCalculationsTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /** @test */
    public function calculate_project_health_combines_all_health_metrics(): void
    {
        // Arrange
        $taskHealth = Mockery::mock(TaskHealthMetricAction::class);
    $collaborationHealth = Mockery::mock(TeamCollaborationMetricAction::class);
    $stageProgress = Mockery::mock(StageProgressMetricAction::class);

    // Use a real Project instance for attribute assignments to avoid Mockery setAttribute errors
    $project = new Project();

        // Mock config
        config(['project-metrics.health.weights' => [
            'tasks' => 0.3,
            'communication' => 0.2,
            'collaboration' => 0.2,
            'stage' => 0.2,
            'activity' => 0.1,
        ]]);

        // Mock method calls
        $taskHealth->shouldReceive('execute')->with($project)->once()->andReturn(80.0);
        $collaborationHealth->shouldReceive('execute')->with($project)->once()->andReturn(60.0);
        $stageProgress->shouldReceive('execute')->with($project)->once()->andReturn([
            'percentage' => 75,
            'current_stage' => 'Development',
            'status' => 'active',
            'stage_id' => 3
        ]);

        // Communication health is inlined: set recent conversations so the calculation produces 70
        $project->recent_conversations_count = 7;
        // Activity health: set recent activities for activity percentage calculation
        $project->recent_activities_count = 5;

        $action = new ProjectHealthMetricAction(
            $taskHealth,
            $collaborationHealth,
            $stageProgress
        );

        // Act
        $result = $action->execute($project);

        // Assert - Expected: (80*0.3) + (70*0.2) + (60*0.2) + (75*0.2) + (33.3*0.1) = 24 + 14 + 12 + 15 + 3.33 = 68.3
        // Activity percentage: 5/15 * 100 = 33.3%
        $this->assertEquals(68.3, $result);
        $this->assertIsFloat($result);
    }

    /** @test */
    public function calculate_task_health_penalizes_overdue_tasks(): void
    {
        // Arrange
        $project = new Project();
        $project->tasks_count = 10;
        $project->active_tasks_count = 10; // active denominator used by new logic
        $project->completed_tasks_count = 6;
        $project->overdue_tasks_count = 3;

        config(['project-metrics.health.task_health.overdue_penalty_multiplier' => 40]);

        $action = new TaskHealthMetricAction();

        // Act
        $result = $action->execute($project);

        // Assert - New logic: overdue penalty uses non-completed active as denominator
        // nonCompletedActive = 10 - 6 = 4; overdueRate = 3/4 = 75%; penalty = 0.75 * 40 = 30
        // taskHealth = 60 - 30 = 30
        $this->assertEquals(30.0, $result);
    }

    /** @test */
    public function calculate_task_health_handles_empty_project(): void
    {
        // Arrange
        $project = new Project();

        $project->tasks_count = 0;

        $action = new TaskHealthMetricAction();

        // Act
        $result = $action->execute($project);

        // Assert
        $this->assertEquals(0.0, $result);
    }

    // Removed obsolete communication-only test; communication is covered in health composition tests


    /** @test */
    public function calculate_collaboration_health_considers_participation(): void
    {
        // Arrange (use defaults from action):
        // - member_score_per_person = 4 (cap 40)
        // - meeting_score_per_meeting = 10 (cap 30)
        // - participation_max_score = 30
        $project = new Project();
        $project->active_members_count = 4;      // member score = 4 * 4 = 16
        $project->recent_meetings_count = 2;     // meeting score = 2 * 10 = 20
        $project->recent_participants_count = 3; // participation = (3/4) * 30 = 22.5

        $action = new TeamCollaborationMetricAction();

        // Act
        $result = $action->execute($project);

        // Assert - Expected total = 16 + 20 + 22.5 = 58.5
        $this->assertEquals(58.5, $result);
    }

    /** @test */
    // Team engagement action removed - engagement metrics are derived elsewhere

    /** @test */
    public function get_stage_progress_returns_enum_data(): void
    {
        // Arrange
        $project = new Project();
        $project->stage_id = ProjectStage::Development->value;

        $action = new StageProgressMetricAction();

        // Act
        $result = $action->execute($project);

        // Assert
        $this->assertIsArray($result);
        $this->assertArrayHasKey('percentage', $result);
        $this->assertArrayHasKey('current_stage', $result);
        $this->assertArrayHasKey('status', $result);
        $this->assertEquals(ProjectStage::Development->value, $result['stage_id']);
    }

    /** @test */
    public function stage_progress_returns_only_stage_data(): void
    {
        // Arrange
        $project = new Project();
        $project->stage_id = ProjectStage::Development->value;

        $action = new StageProgressMetricAction();

        // Act
        $result = $action->execute($project);

        // Assert - StageProgress now only returns stage data, not activity
        $this->assertIsArray($result);
        $this->assertArrayHasKey('percentage', $result);
        $this->assertArrayHasKey('current_stage', $result);
        $this->assertArrayHasKey('status', $result);
        $this->assertArrayHasKey('stage_id', $result);
        $this->assertArrayNotHasKey('progress_score', $result);
        $this->assertArrayNotHasKey('activity_bonus', $result);
    }

    /** @test */
    public function get_upcoming_risk_identifies_soon_due_tasks(): void
    {
        // Arrange: UpcomingRiskMetricAction now reads precomputed counts from the project
        $project = new Project();
        $project->tasks_due_soon_count = 2;
        $project->tasks_at_risk_count = 1;

        $action = new UpcomingRiskMetricAction();

        // Act
        $result = $action->execute($project);

        // Assert - shape: score, at_risk_count, due_soon_count
        $this->assertIsArray($result);
        $this->assertArrayHasKey('score', $result);
        $this->assertArrayHasKey('at_risk_count', $result);
        $this->assertArrayHasKey('due_soon_count', $result);
        $this->assertEquals(2, $result['due_soon_count']);
        $this->assertEquals(1, $result['at_risk_count']);
        // atRisk/dueSoon = 1/2 => 50.0, severity boost for 1 => 1.0
        $this->assertEquals(50.0, $result['score']);
    }

    /** @test */
    public function project_health_includes_activity_calculation(): void
    {
        // Arrange - Test that ProjectHealthMetricAction properly calculates activity percentage
        $taskHealth = Mockery::mock(TaskHealthMetricAction::class);
        $collaborationHealth = Mockery::mock(TeamCollaborationMetricAction::class);
        $stageProgress = Mockery::mock(StageProgressMetricAction::class);

       // Use a real Project instance so attribute assignments work normally
       $project = new Project();
       $project->recent_activities_count = 20; // Should be capped at 100%
       $project->recent_conversations_count = 5;

        config([
            'project-metrics.health.weights' => [
                'tasks' => 0.3, 'communication' => 0.2, 'collaboration' => 0.2, 'stage' => 0.2, 'activity' => 0.1,
            ],
            'project-metrics.progress.activity_count_for_full' => 15
        ]);

        $taskHealth->shouldReceive('execute')->andReturn(80.0);
        $collaborationHealth->shouldReceive('execute')->andReturn(60.0);
        $stageProgress->shouldReceive('execute')->andReturn(['percentage' => 75]);

        $action = new ProjectHealthMetricAction($taskHealth, $collaborationHealth, $stageProgress);

        // Act
        $result = $action->execute($project);

        // Assert - Activity should be 100% (20/15 capped at 100%), contributing 10% weight
        $expected = (80*0.3) + (50*0.2) + (60*0.2) + (75*0.2) + (100*0.1); // = 24+10+12+15+10 = 71
        $this->assertEquals(71.0, $result);
    }

        /** @test */
        public function stage_progress_completed_and_postponed_statuses(): void
        {
    $p = new Project(); 
    $p->stage_id = ProjectStage::Completed->value;
    $a = new StageProgressMetricAction();
    $completed = $a->execute($p);
    $this->assertEquals('completed', $completed['status']);

    $p->stage_id = ProjectStage::Postponed->value;
    $postponed = $a->execute($p);
    $this->assertEquals('postponed', $postponed['status']);
    }
}
