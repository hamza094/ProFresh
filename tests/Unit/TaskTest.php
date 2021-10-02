<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;


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
     $this->signIn();
       $task = create('App\Models\Task');
       $this->assertInstanceOf('App\Models\Project', $task->project);
   }

   /** @test*/
public function it_can_be_completed(){
  $this->signIn();
    $task = create('App\Models\Task');
    $this->assertFalse($task->completed);
    $task->complete();
    $this->assertTrue($task->fresh()->completed);
    $this->assertEquals(1,$task->project->tasks->count());
}

/** @test*/
public function it_can_be_Uncompleted(){
  $this->signIn();
  $task = create('App\Models\Task');
        $task->complete();
        $this->assertEquals(1,$task->project->tasks->count());
        $this->assertTrue($task->completed);
        $task->incomplete();
        $this->assertFalse($task->fresh()->completed);
        //$this->assertEquals(0,$task->project->tasks->count());
}


}
