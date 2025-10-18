<?php

namespace Tests\Feature\Api\V1;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use App\Traits\ProjectSetup;
use App\Models\Project;
use App\Models\TaskStatus;
use App\Models\User;
use Tests\TestCase;
use Carbon\Carbon;
use App\Models\Task;

class TaskTest extends TestCase
{
  use RefreshDatabase,ProjectSetup;

    /** @test */
    public function allowed_user_see_archived_tasks()
    { 
       Task::factory(['deleted_at'=>now()])
        ->count(3)
        ->for($this->project)
        ->create(); 

        $this->getJson($this->project->path().'/tasks?request=archived')
                ->assertOk()
                ->assertJsonCount(3, 'tasksData')
                ->assertJsonStructure(['message', 'tasksData']);
    }


    /** @test */
    public function allowed_user_see_active_tasks_and_paginate()
    { 
      Task::factory()
        ->count(9)
        ->for($this->project)
        ->create(); 

      $this->getJson($this->project->path(). '/tasks')      
            ->assertOk()
            ->assertJsonCount(3, 'tasksData')
            ->assertJsonStructure([
                'message',
                'tasksData' => [
                'data' => [],'links','meta',
                ],
            ]);
    }


    /** @test */
    public function task_requires_a_title()
    {
       $task=Task::factory()->make(['title'=>null,'project_id'=>$this->project->id]);

       $this->postJson($task->path(),$task->toArray())->assertJsonValidationErrors('title');
    }


     /** @test */
     public function allowed_user_can_create_projects_task()
     {
        $this->postJson($this->project->path().'/tasks',[
          'title' => 'My Project Task',
          'status_id'=>$this->status->id,
      ])->assertCreated()
          ->assertJson([
           "task"=>[      
           'id'=>1,
           'title'=>'My Project Task'
          ]]);

        $this->assertDatabaseHas('tasks',['title'=>'My Project Task']);
   }


   /** @test */
   public function duplicate_project_task_can_not_be_created()
   {
     $this->project->tasks()->create([
        'title'=>'Project Task',
        'user_id'=>$this->project->user->id
    ]);

    $this->postJson($this->project->path().'/tasks',[
        'title' => 'Project Task',
        'status_id'=>$this->status->id
        ])->assertJsonValidationErrors('title');

    $project2=Project::factory()->for($this->user)->create();

    $this->postJson($project2->path().'/tasks',
         ['title' => 'Project Task'])
         ->assertCreated();   
   }


   /** @test */
   public function task_limit_per_project()
   {
     Task::factory()->count(config('app.project.taskLimit'))
     ->for($this->project)->create();

     $this->postJson($this->project->path().'/tasks',
       ['title' => 'Project Task'])
       ->assertUnprocessable()
      ->assertJsonValidationErrors('tasks');
    }


    /** @test */
    public function allowed_user_can_get_task_resource()
    {
      $task=$this->project->tasks()->create([
        'title'=>'Project Task',
        'user_id'=>$this->project->user->id
    ]);

      $this->getJson($task->path())
      ->assertOk()
      ->assertJson([
            'id'=>$task->id,
            'title'=>$task->title,
        ]);
    }


  /** @test */  
  public function allowed_user_can_update_project_task()
  {
     $task=$this->project->addTask('test task');

     $updatedTitle="Task title updated";
     $updatedDescription="Task updated description";

     $status2=TaskStatus::factory()->create();

     $this->putJson($task->path(), [
      'title' => $updatedTitle,
      'description'=>$updatedDescription,
      'status_id'=>$status2->id
    ])->assertJsonPath('task.title', $updatedTitle);

    $task->refresh();

     $this->assertDatabaseHas('tasks',[
      'title'=>$updatedTitle,
      'description'=>$updatedDescription,
    ])
     ->assertEquals($task->status->id,$status2->id);
    }


    /** @test */
    public function due_at_timezone_works_as_expected()
    {
      $this->user->update([
        'timezone'=>'Asia/Karachi'
      ]);

      $due_at = '2024-12-04T15:00:00';

      $task=$this->project->addTask('test task');

      $this->putJson($task->path(), [
        'due_at'=>$due_at,
      ]);

      $expectedDueAt = Carbon::parse($due_at,$this->user->timezone)->setTimezone('UTC');

      $this->assertEquals($expectedDueAt->toDateTimeString(), $task->refresh()->due_at->toDateTimeString());
    }
   

   /** @test */
   public function task_gate_check()
   { 
      $task=Task::factory()->for($this->project)->create();

       $this->deleteJson(route('task.archive', [
        'project' => $this->project->slug,
        'task' => $task->id
    ]));

      $response= $this->putJson($task->path(), [
      'title' => 'updated task',
    ])->assertJsonValidationErrors([
        'task' => 'Task is archived. Activate the task to proceed.'
    ]);
   }


   /** @test */
   public function task_policy_check()
   { 
      $task=Task::factory()->for($this->project)->create();

      $user=User::factory()->create();

      Sanctum::actingAs(
       $user,
   );

    $this->deleteJson(route('task.archive', [
        'project' => $this->project->slug,
        'task' => $task->id
    ]))->assertForbidden();
   }

}
