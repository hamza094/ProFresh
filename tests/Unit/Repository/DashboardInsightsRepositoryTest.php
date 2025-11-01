<?php

declare(strict_types=1);

namespace Tests\Unit\Repository;

use App\Models\Project;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use App\Repository\DashboardInsightsRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardInsightsRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_handles_no_projects()
    {
        $user = User::factory()->create();
        $repo = new DashboardInsightsRepository;
        $projects = $repo->getUserProjects($user->id);
        $this->assertCount(0, $projects);
        $this->assertEquals(100.0, $repo->getTaskCompletionRate($user->id));
        $this->assertEquals(0, $repo->getOverdueTasksCount($user->id));
        $this->assertEquals(0, $repo->getCriticalProjectsCount($projects));
    }

    /** @test */
    public function it_handles_projects_with_no_tasks()
    {
        $user = User::factory()->create();
        Project::factory()->for($user)->create();
        $repo = new DashboardInsightsRepository;
        $projects = $repo->getUserProjects($user->id);
        $this->assertCount(1, $projects);
        $this->assertEquals(100.0, $repo->getTaskCompletionRate($user->id));
        $this->assertEquals(0, $repo->getOverdueTasksCount($user->id));
        $this->assertEquals(0, $repo->getCriticalProjectsCount($projects));
    }

    /** @test */
    public function it_handles_all_tasks_completed()
    {
        TaskStatus::factory(['id' => 4])->create();
        $user = User::factory()->create();
        $project = Project::factory()->for($user)->create();

        Task::factory()->completed()
            ->for($project)
            ->count(3)
            ->create([
                'user_id' => $user->id,
            ]);

        $repo = new DashboardInsightsRepository;
        $this->assertEquals(100.0, $repo->getTaskCompletionRate($user->id));
        $this->assertEquals(0, $repo->getOverdueTasksCount($user->id));
    }

    /** @test */
    public function it_handles_all_tasks_overdue()
    {
        TaskStatus::factory()->create();
        $user = User::factory()->create();
        $project = Project::factory()->for($user)->create();
        Task::factory()->overdue()->for($project)->count(3)->create(['user_id' => $user->id]);
        $repo = new DashboardInsightsRepository;
        $this->assertEquals(0.0, $repo->getTaskCompletionRate($user->id));
        $this->assertEquals(3, $repo->getOverdueTasksCount($user->id));
    }

    /** @test */
    public function it_handles_threshold_boundary_for_critical_projects()
    {
        TaskStatus::factory()->create();
        $user = User::factory()->create();
        $project = Project::factory()->for($user)->create();
        $threshold = (int) config('dashboard.insights.critical_project.overdue_threshold', 3);
        Task::factory()->overdue()->for($project)->count($threshold)->create(['user_id' => $user->id]);
        $repo = new DashboardInsightsRepository;
        $projects = $repo->getUserProjects($user->id);
        $criticalCount = $repo->getCriticalProjectsCount($projects);
        $this->assertEquals(0, $criticalCount, 'Should not be critical at threshold');
        Task::factory()->overdue()->for($project)->create(['user_id' => $user->id]);
        $projects = $repo->getUserProjects($user->id);
        $criticalCount = $repo->getCriticalProjectsCount($projects);
        $this->assertEquals(1, $criticalCount, 'Should be critical above threshold');
    }

    /** @test */
    public function it_handles_multiple_projects_mixed_states()
    {
        TaskStatus::factory()->create();
        TaskStatus::factory(['id' => 4])->create();
        $user = User::factory()->create();
        $project1 = Project::factory()->for($user)->create();
        $project2 = Project::factory()->for($user)->create();
        Task::factory()->overdue()->for($project1)->count(2)->create(['user_id' => $user->id]); // overdue
        Task::factory()->completed()->for($project2)->count(2)->create(['user_id' => $user->id]);

        $repo = new DashboardInsightsRepository;
        $projects = $repo->getUserProjects($user->id);
        $this->assertEquals(2, $projects->count());
        $this->assertEquals(2, $repo->getOverdueTasksCount($user->id));
        $this->assertEquals(50.0, $repo->getTaskCompletionRate($user->id));
    }

    /** @test */
    public function it_handles_user_as_active_member_not_owner()
    {
        $user = User::factory()->create();
        $owner = User::factory()->create();
        $project = Project::factory()->for($owner)->create();
        // Attach user as active member
        $project->members()->attach($user->id, ['active' => true]);

        $statusCompleted = TaskStatus::factory(['id' => 4])->create();
        $status = TaskStatus::factory()->create();
        Task::factory()->completed()->for($project)->count(2)->create(['user_id' => $user->id, 'status_id' => $statusCompleted->id, 'due_at' => now()->subDay()]);
        Task::factory()->overdue()->for($project)->count(1)->create(['user_id' => $user->id, 'status_id' => $status->id, 'due_at' => now()->subDay()]);
        $repo = new DashboardInsightsRepository;
        $projects = $repo->getUserProjects($user->id);
        $this->assertCount(1, $projects);
        $this->assertEquals(66.7, round($repo->getTaskCompletionRate($user->id), 2));
        $this->assertEquals(1, $repo->getOverdueTasksCount($user->id));
    }

    /** @test */
    public function it_excludes_inactive_members_from_results()
    {
        $user = User::factory()->create();
        $owner = User::factory()->create();
        $project = Project::factory()->for($owner)->create();
        // Attach user as inactive member (simulate by not using activeMembers relation)
        $project->members()->attach($user->id, ['active' => false]);
        $statusCompleted = TaskStatus::factory(['id' => 4])->create();
        Task::factory()->for($project)->count(2)->create(['user_id' => $user->id, 'status_id' => $statusCompleted->id, 'due_at' => now()->subDay()]);
        $repo = new DashboardInsightsRepository;
        $projects = $repo->getUserProjects($user->id);
        $this->assertCount(0, $projects, 'Inactive member should not see project');
        $this->assertEquals(100.0, $repo->getTaskCompletionRate($user->id));
    }
}
