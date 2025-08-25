<?php

namespace Tests\Feature\Api\V1\ProjectDashboard;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use App\Traits\ProjectSetup;
use App\Enums\TaskStatus as TaskStatusEnum;
use Carbon\Carbon;

class UserTasksDataTest extends TestCase
{
    use RefreshDatabase, ProjectSetup { setUp as projectSetUp; }

    protected function setUp(): void
    {
        parent::setUp();
        $this->projectSetUp();

        // Seed canonical TaskStatus rows needed by these tests
        TaskStatus::query()->firstOrCreate(
            ['id' => TaskStatusEnum::IN_PROGRESS],
            ['label' => 'In Progress', 'color' => '#0000FF', 'user_id' => $this->user->id]
        );
        TaskStatus::query()->firstOrCreate(
            ['id' => TaskStatusEnum::COMPLETED],
            ['label' => 'Completed', 'color' => '#00FF00', 'user_id' => $this->user->id]
        );
    }

    /** @test */
    public function auth_user_can_view_tasks_with_user_created_and_task_assigned_filters()
    {
        // Create tasks for the authenticated user
        Task::factory(['user_id' => $this->user->id, 'project_id' => $this->project->id])->count(3)->create();

        // Create a task by another user but assigned to authenticated user
        $randomUser = User::factory()->create();
        $assignedTask = Task::factory(['user_id' => $randomUser->id])->create();
        $assignedTask->assignee()->attach($this->user);

        $response = $this->getJson('api/v1/tasksdata?task_assigned=1&user_created=1');

        $response->assertOk()
            ->assertJsonStructure([
                'data' => [],
                'meta' => [
                    'applied_filters',
                    'total'
                ]
            ]);

        $responseData = $response->json();

        $this->assertEquals(['Filter by Created', 'Filter by Assigned'], $responseData['meta']['applied_filters']);
        $this->assertCount(4, $responseData['data']);
        $this->assertEquals(4, $responseData['meta']['total']);
        $this->assertEquals($assignedTask->title, $responseData['data'][3]['title']);
    }

    /** @test */
    public function auth_user_can_filter_tasks_by_user_created_only()
    {
        // Create tasks for the authenticated user
        Task::factory(['user_id' => $this->user->id, 'project_id' => $this->project->id])->count(2)->create();

        // Create a task by another user (should not appear)
        $randomUser = User::factory()->create();
        Task::factory(['user_id' => $randomUser->id])->create();

        $response = $this->getJson('api/v1/tasksdata?user_created=1');

        $response->assertOk();
        $responseData = $response->json();

        $this->assertEquals(['Filter by Created'], $responseData['meta']['applied_filters']);
        $this->assertCount(2, $responseData['data']);
        $this->assertEquals(2, $responseData['meta']['total']);
    }

    /** @test */
    public function auth_user_can_filter_tasks_by_task_assigned_only()
    {
        // Create a task by another user and assign to authenticated user
        $randomUser = User::factory()->create();
        $assignedTask = Task::factory(['user_id' => $randomUser->id])->create();
        $assignedTask->assignee()->attach($this->user);

        // Create a task by authenticated user (should not appear with task_assigned filter only)
        Task::factory(['user_id' => $this->user->id, 'project_id' => $this->project->id])->create();

        $response = $this->getJson('api/v1/tasksdata?task_assigned=1');

        $response->assertOk();
        $responseData = $response->json();

        $this->assertEquals(['Filter by Assigned'], $responseData['meta']['applied_filters']);
        $this->assertCount(1, $responseData['data']);
        $this->assertEquals(1, $responseData['meta']['total']);
        $this->assertEquals($assignedTask->title, $responseData['data'][0]['title']);
    }

    /** @test */
    public function auth_user_can_filter_tasks_by_completed_status()
    {
        // Create completed tasks
        Task::factory([
            'user_id' => $this->user->id,
            'project_id' => $this->project->id,
            'status_id' => TaskStatusEnum::COMPLETED
        ])->count(2)->create();

        // Create non-completed task
        Task::factory([
            'user_id' => $this->user->id,
            'project_id' => $this->project->id,
            'status_id' => TaskStatusEnum::IN_PROGRESS
        ])->create();

        $response = $this->withoutExceptionHandling()->getJson('api/v1/tasksdata?user_created=1&completed=1');

        $response->assertOk();
        $responseData = $response->json();

        $this->assertEquals(['Filter by Created', 'Filter by Completed'], $responseData['meta']['applied_filters']);
        $this->assertCount(2, $responseData['data']);
        $this->assertEquals(2, $responseData['meta']['total']);
    }

    /** @test */
    public function auth_user_can_filter_tasks_by_overdue_status()
    {
        // Create overdue tasks
        Task::factory([
            'user_id' => $this->user->id,
            'project_id' => $this->project->id,
            'due_at' => Carbon::yesterday(),
            'status_id' => TaskStatusEnum::IN_PROGRESS
        ])->count(2)->create();

        // Create non-overdue task
        Task::factory([
            'user_id' => $this->user->id,
            'project_id' => $this->project->id,
            'due_at' => Carbon::tomorrow(),
            'status_id' => TaskStatusEnum::IN_PROGRESS
        ])->create();

        $response = $this->getJson('api/v1/tasksdata?user_created=1&overdue=1');

        $response->assertOk();
        $responseData = $response->json();

        $this->assertEquals(['Filter by Created', 'Filter by Overdue'], $responseData['meta']['applied_filters']);
        $this->assertCount(2, $responseData['data']);
    }

    /** @test */
    public function auth_user_can_filter_tasks_by_remaining_status()
    {
        // Create remaining (not completed) tasks
        Task::factory([
            'user_id' => $this->user->id,
            'project_id' => $this->project->id,
            'status_id' => TaskStatusEnum::IN_PROGRESS
        ])->count(2)->create();

        // Create completed task
        Task::factory([
            'user_id' => $this->user->id,
            'project_id' => $this->project->id,
            'status_id' => TaskStatusEnum::COMPLETED
        ])->create();

        $response = $this->getJson('api/v1/tasksdata?user_created=1&remaining=1');

        $response->assertOk();
        $responseData = $response->json();

        $this->assertEquals(['Filter by Created', 'Filter by Remaining'], $responseData['meta']['applied_filters']);
        $this->assertCount(2, $responseData['data']);
    }

    /** @test */
    public function request_requires_at_least_one_filter()
    {
        $response = $this->getJson('api/v1/tasksdata');

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['filters']);
    }

    /** @test */
    public function request_with_false_values_requires_at_least_one_filter()
    {
        $response = $this->getJson('api/v1/tasksdata?user_created=0&completed=0');

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['filters']);
    }

    /** @test */
    public function status_filters_without_user_context_default_to_user_tasks()
    {
        // Create overdue task by authenticated user
        Task::factory([
            'user_id' => $this->user->id,
            'project_id' => $this->project->id,
            'due_at' => Carbon::yesterday(),
            'status_id' => TaskStatusEnum::IN_PROGRESS
        ])->create();

        // Create overdue task by another user (should not appear)
        $otherUser = User::factory()->create();
        Task::factory([
            'user_id' => $otherUser->id,
            'due_at' => Carbon::yesterday(),
            'status_id' => TaskStatusEnum::IN_PROGRESS
        ])->create();

        // Create overdue task assigned to authenticated user
        $assignedTask = Task::factory([
            'user_id' => $otherUser->id,
            'due_at' => Carbon::yesterday(),
            'status_id' => TaskStatusEnum::IN_PROGRESS
        ])->create();
        $assignedTask->assignee()->attach($this->user);

        $response = $this->getJson('api/v1/tasksdata?overdue=1');

        $response->assertOk();
        $responseData = $response->json();

        // Should return 2 tasks: 1 created by user + 1 assigned to user
        $this->assertCount(2, $responseData['data']);
        $this->assertEquals(2, $responseData['meta']['total']);
    }
}
