<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Actions\ProjectMetrics\CalculateProjectHealthAction;
use App\Actions\ProjectMetrics\CalculateTaskHealthAction;
use App\Actions\ProjectMetrics\CalculateCommunicationHealthAction;
use App\Actions\ProjectMetrics\CalculateCollaborationHealthAction;
use App\Actions\ProjectMetrics\CalculateProgressHealthAction;
use App\Actions\ProjectMetrics\CalculateTeamEngagementAction;
use App\Actions\ProjectMetrics\GetStageProgressAction;
use App\Actions\ProjectMetrics\GetUpcomingRiskAction;
use App\Models\Project;
use App\Enums\ProjectStage;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
        $taskHealth = Mockery::mock(CalculateTaskHealthAction::class);
        $communicationHealth = Mockery::mock(CalculateCommunicationHealthAction::class);
        $collaborationHealth = Mockery::mock(CalculateCollaborationHealthAction::class);
        $progressHealth = Mockery::mock(CalculateProgressHealthAction::class);
        $stageProgress = Mockery::mock(GetStageProgressAction::class);

        $project = Mockery::mock(Project::class);
        $stageData = ['percentage' => 75, 'status' => 'active'];

        // Mock config
        config(['project-metrics.health.weights' => [
            'tasks' => 0.4,
            'communication' => 0.25,
            'collaboration' => 0.2,
            'progress' => 0.15,
        ]]);

        // Mock method calls
        $taskHealth->shouldReceive('execute')->with($project)->once()->andReturn(80.0);
        $communicationHealth->shouldReceive('execute')->with($project)->once()->andReturn(70.0);
        $collaborationHealth->shouldReceive('execute')->with($project)->once()->andReturn(60.0);
        $stageProgress->shouldReceive('execute')->with($project)->once()->andReturn($stageData);
        $progressHealth->shouldReceive('execute')->with($project, $stageData)->once()->andReturn(85.0);

        $action = new CalculateProjectHealthAction(
            $taskHealth,
            $communicationHealth,
            $collaborationHealth,
            $progressHealth,
            $stageProgress
        );

        // Act
        $result = $action->execute($project);

        // Assert - Expected: (80*0.4) + (70*0.25) + (60*0.2) + (85*0.15) = 32 + 17.5 + 12 + 12.75 = 74.25
        $this->assertEquals(74.3, $result);
        $this->assertIsFloat($result);
    }

    /** @test */
    public function calculate_task_health_penalizes_overdue_tasks(): void
    {
        // Arrange
        $project = new Project();
        $project->tasks_count = 10;
        $project->completed_tasks_count = 6;
        $project->overdue_tasks_count = 3;

        config(['project-metrics.health.task_health.overdue_penalty_multiplier' => 40]);

        $action = new CalculateTaskHealthAction();

        // Act
        $result = $action->execute($project);

        // Assert - Expected: (6/10)*100 - (3/10)*40 = 60 - 12 = 48
        $this->assertEquals(48.0, $result);
    }

    /** @test */
    public function calculate_task_health_handles_empty_project(): void
    {
        // Arrange
        $project = new Project();

        $project->tasks_count = 0;

        $action = new CalculateTaskHealthAction();

        // Act
        $result = $action->execute($project);

        // Assert
        $this->assertEquals(0.0, $result);
    }

    /** @test */
    public function calculate_communication_health_multiplies_conversations(): void
    {
        // Arrange
        $project = new Project();

        $project->recent_conversations_count = 5;

        $action = new CalculateCommunicationHealthAction();

        // Act
        $result = $action->execute($project);

        // Assert - Expected: min(100, 5 * 10) = 50
        $this->assertEquals(50.0, $result);
    }

    /** @test */
    public function calculate_collaboration_health_considers_participation(): void
    {
        // Arrange
        $project = Mockery::mock(Project::class);
        $project->active_members_count = 4;
        $project->recent_meetings_count = 2;

        $activities = Mockery::mock(HasMany::class);
        $activities->shouldReceive('where->distinct->count')->andReturn(3);
        $project->shouldReceive('activities')->andReturn($activities);

        config([
            'project-metrics.health.collaboration' => [
                'member_score_multiplier' => 10,
                'meeting_score_multiplier' => 15,
                'participation_score_multiplier' => 50,
            ],
            'project-metrics.time_periods.recent_activity_days' => 7
        ]);

        $action = new CalculateCollaborationHealthAction();

        // Act
        $result = $action->execute($project);

        // Assert - Expected: min(100, (4*10) + (2*15) + ((3/4)*50)) = min(100, 40+30+37.5) = 100
        $this->assertEquals(100.0, $result);
    }

    /** @test */
    public function calculate_team_engagement_uses_config_multipliers(): void
    {
        // Arrange
        $project = new Project();
        $project->recent_tasks_count = 5;
        $project->recent_conversations_count = 3;
        $project->recent_meetings_count = 2;
        $project->active_members_count = 4;

        config([
            'project-metrics.engagement' => [
                'task_multiplier' => 2,
                'conversation_multiplier' => 1.5,
                'meeting_multiplier' => 5,
                'member_multiplier' => 3,
            ]
        ]);

        $action = new CalculateTeamEngagementAction();

        // Act
        $result = $action->execute($project);

        // Assert - Expected: (5*2) + (3*1.5) + (2*5) + (4*3) = 10 + 4.5 + 10 + 12 = 36.5
        $this->assertEquals(36.5, $result);
    }

    /** @test */
    public function get_stage_progress_returns_enum_data(): void
    {
        // Arrange
        $project = new Project();
        $project->stage_id = ProjectStage::Development->value;

        $action = new GetStageProgressAction();

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
    public function calculate_progress_health_handles_postponed_status(): void
    {
        // Arrange
        $project = new Project();
        $stageProgressAction = Mockery::mock(GetStageProgressAction::class);
        $stageProgress = ['percentage' => 50, 'status' => 'postponed'];

        $action = new CalculateProgressHealthAction();

        // Act
        $result = $action->execute($project, $stageProgress);

        // Assert
        $this->assertEquals(0, $result);
    }

    /** @test */
    public function get_upcoming_risk_identifies_soon_due_tasks(): void
    {
        // Arrange
        $project = Mockery::mock(Project::class);
        $tasks = Mockery::mock(HasMany::class);
        
        // Create mock task objects with activities method
        $task1 = Mockery::mock();
        $task1->id = 1;
        $task1->shouldReceive('activities->where->exists')->andReturn(false);
        
        $task2 = Mockery::mock();
        $task2->id = 2;
        $task2->shouldReceive('activities->where->exists')->andReturn(false);
        
        $soonTasks = collect([$task1, $task2]);

        $tasks->shouldReceive('dueSoon')->with(48)->andReturnSelf();
        $tasks->shouldReceive('get')->andReturn($soonTasks);
        $project->shouldReceive('tasks')->andReturn($tasks);

        config([
            'project-metrics.time_periods' => [
                'risk_assessment_hours' => 48,
                'task_inactivity_days' => 5
            ]
        ]);

        $action = new GetUpcomingRiskAction();

        // Act
        $result = $action->execute($project);

        // Assert
        $this->assertIsArray($result);
        $this->assertArrayHasKey('count', $result);
        $this->assertArrayHasKey('tasks', $result);
        $this->assertEquals(2, $result['count']);
        $this->assertEquals([1, 2], $result['tasks']);
    }

    /** @test */
    public function calculate_progress_health_rounds_total_correctly(): void
    {
        // Arrange
        $project = new Project();
        $project->recent_activities_count = 7;

        config([
            'project-metrics.progress' => [
                'stage_weight' => 0.6,
                'activity_multiplier' => 5,
                'activity_max_score' => 40,
            ]
        ]);

        $stageProgress = ['percentage' => 80, 'status' => 'active'];

        $action = new CalculateProgressHealthAction();

        // Act
        $result = $action->execute($project, $stageProgress);

        // Assert
        // Calculation: (80 * 0.6) + min(40, 7 * 5) = 48 + 35 = 83.0
        $this->assertEquals(83.0, $result);
        $this->assertIsFloat($result);
    }
}
