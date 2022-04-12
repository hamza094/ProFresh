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
      $task = Task::factory()->create();
      $this->assertInstanceOf(Project::class, $task->project);
   }

    /** @test */
    public function it_can_be_completed()
    {
       $task=Task::factory()->create();
       $this->assertFalse($task->completed);
       $task->complete();
       $this->assertTrue($task->fresh()->completed);
    }

     /** @test */
     public function it_can_mark_uncompleted()
     {
        $task = Task::factory()->create(['completed'=>1]);
        $this->assertTrue($task->completed);
        $task->incomplete();
        $this->assertFalse($task->fresh()->completed);
    }


}
