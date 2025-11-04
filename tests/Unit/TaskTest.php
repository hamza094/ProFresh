<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     */

    /** @test */
    public function it_belongs_to_a_project(): void
    {
        $task = Task::factory()->make();

        $this->assertInstanceOf(Project::class, $task->project);
    }
}
