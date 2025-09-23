<?php

namespace Tests\Support;

use App\Models\Activity;
use App\Models\Project;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;

trait BuildsInsightTestData
{
    /**
     * Seed a project with a realistic mix of tasks, activities, and members.
     */
    protected function seedRealisticData(Project $project, User $actor): void
    {
        // Create different task statuses
        $completedStatus = TaskStatus::factory()->completed()->create();
        $progressStatus  = TaskStatus::factory()->progress()->create();
        $pendingStatus   = TaskStatus::factory()->create(); // Default "Not Started"

        // Mix of completed, in-progress, and pending/overdue tasks
        Task::factory()->count(6)->create([
            'project_id' => $project->id,
            'status_id'  => $completedStatus->id,
            'updated_at' => now()->subDays(2),
        ]);

        Task::factory()->count(3)->create([
            'project_id' => $project->id,
            'status_id'  => $progressStatus->id,
            'due_at'     => now()->addDays(5),
        ]);

        Task::factory()->create([
            'project_id' => $project->id,
            'status_id'  => $pendingStatus->id,
            'due_at'     => now()->subDays(1), // Overdue
        ]);

        // Recent activities contribute to activity and distinct participants
        Activity::factory()->count(8)->create([
            'project_id' => $project->id,
            'user_id'    => $actor->id,
            'created_at' => now()->subDays(3),
        ]);

        // Additional project members for collaboration denominator
        $extra = User::factory()->count(2)->create();
        $project->members()->attach($extra->pluck('id'));
    }

    /**
     * Assert that an insight array has a numeric data.value within the given range.
     */
    protected function assertInsightValue(array $insight, float|int $min = 0, float|int $max = 100): void
    {
        $this->assertIsArray($insight['data']);
        $this->assertArrayHasKey('value', $insight['data']);
        $this->assertIsNumeric($insight['data']['value']);
        $this->assertGreaterThanOrEqual($min, $insight['data']['value']);
        $this->assertLessThanOrEqual($max, $insight['data']['value']);
    }
}
