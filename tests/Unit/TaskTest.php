<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Task;
use App\Models\Project;

class TaskTest extends TestCase
{
  use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */

   /** @test */
   public function it_belongs_to_a_project()
   {
      $task = Task::factory()->make();
   
      $this->assertInstanceOf(Project::class, $task->project);
   }
}
