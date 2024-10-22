<?php

namespace Tests\Feature\Api\V1;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\Hash;
use App\Traits\ProjectSetup;
use App\Policies\TasksPolicy;
use Illuminate\Support\Facades\Notification;
use App\Notifications\TaskAssigned;
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
       Task::factory(['deleted_at'=>Carbon::now()])
        ->count(3)
        ->for($this->project)
        ->create(); 

        $response = $this->getJson($this->project->path().'/tasks?request=archived');

        $response->assertStatus(200)
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

      $response = $this->getJson($this->project->path(). '/tasks');

       $response->assertStatus(200)
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

       $response=$this->postJson($task->path(),$task->toArray());

       $response->assertJsonValidationErrors('title');
     }

     /** @test */
     public function allowed_user_can_create_projects_task()
     {
       $response=$this->postJson($this->project->path().'/tasks',[
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
     $this->project->tasks()->create(['title'=>'Project Task','user_id'=>$this->project->user->id]);

     $response=$this->postJson($this->project->path().'/tasks',[
        'title' => 'Project Task',
        'status_id'=>$this->status->id
        ])->assertJsonValidationErrors('title');

      $project2=Project::factory()->for($this->user)->create();

      $response=$this->postJson($project2->path().'/tasks',
         ['title' => 'Project Task'])
         ->assertCreated();   
 }

   /** @test */
   public function task_limit_per_project()
   {
     Task::factory()->count(config('app.project.taskLimit'))
     ->for($this->project)->create();

     $response=$this->postJson($this->project->path().'/tasks',
       ['title' => 'Project Task'])
       ->assertUnprocessable()
      ->assertJsonValidationErrors('tasks');
    }

  /** @test */  
  public function allowed_user_can_update_project_task()
  {
     $task=$this->project->addTask('test task');

     $updatedTitle="Task title updated";
     $updatedDescription="Task updated description";
     $due_at=now()->addDays(5);

     $status2=TaskStatus::factory()->create();

     $this->putJson($task->path(), [
      'title' => $updatedTitle,
      'description'=>$updatedDescription,
      'due_at'=>$due_at,
      'status_id'=>$status2->id
    ])->assertJson([
        "task"=>['id'=>$task->id,'title'=>$updatedTitle]]);

    $task->refresh();

     $this->assertDatabaseHas('tasks',[
      'title'=>$updatedTitle,
      'description'=>$updatedDescription,
      'due_at'=>$due_at,
    ])
     ->assertEquals($task->status->id,$status2->id);
    }

   /** @test */
   public function members_assign_to_task()
   {
      $task=$this->project->addTask('test task');

      $user=User::factory()->create();
      
      $members = [$user->id];

     $user->members()->syncWithoutDetaching([
        $this->project->id => ['active' => true]]);

      $this->assignMembersToTask($task, $members)
            ->assertSuccessful()
            ->assertJson([
              'message' => 'Task assigned to member Successfully',
            ]);

        $this->assertCount(1, $user->notifications);

        $this->assertDatabaseHas('task_user', [
            'task_id' => $task->id,
            'user_id' => $user->id,
        ]);

        $task->assignee()->attach($user->id);

        $this->assignMembersToTask($task, $members)
              ->assertStatus(422)
              ->assertJsonValidationErrors(['members' => 'One or more users are already assigned to the task.']);
    }  

    /** @test */
    public function unassign_a_member_from_a_task()
    {
        $task=$this->project->addTask('test task');

        $task->assignee()->attach($this->user);

        $response= $this->patchJson(route('task.unassign', [
        'project' => $this->project->slug,
        'task' => $task->id,
    ]), ['member' => $this->user->id])
        ->assertSuccessful()
        ->assertJson([
            'message' => 'Task member Unassigned',
        ]);

        $this->assertDatabaseMissing('task_user', [
            'task_id' => $task->id,
            'user_id' => $this->user->id,
        ]);

     $response= $this->patchJson(route('task.unassign', [
        'project' => $this->project->slug,
        'task' => $task->id,
    ]), ['member' => $this->user->id])
        ->assertStatus(422)
        ->assertJsonValidationErrors(['member' => 'The selected user is not a current member of task.']);
    }

     
   /** @test */   
   public function allowed_user_can_archive_and_unarchive_task()
   {
      $task = Task::factory()->for($this->project)->create();

      $this->deleteJson(route('task.archive', [
        'project' => $this->project->slug,
        'task' => $task->id
    ]));

      $this->assertSoftDeleted($task);

     $this->getJson(route('task.unarchive', [
        'project' => $this->project->slug,
        'task' => $task->id,
      ]));

      $this->assertNotSoftDeleted($task);
   }

   /** @test */
   public function allowed_user_can_delete_task()
   {
     $task=Task::factory()->for($this->project)->create();

      $this->deleteJson($task->path())->assertNoContent();

     $this->assertModelMissing($task);
   }

   /** @test */
   public function task_gate_check()
   { 
      $task=Task::factory()->for($this->project)->create();

       $this->deleteJson(route('task.archive', [
        'project' => $this->project->slug,
        'task' => $task->id
    ]));

       $response=$this->putJson($task->path(), [
      'title' => 'this is updated task',
    ])->assertJsonValidationErrors(['task' => 'Task is archived. Activate the task to proceed.']);
   }

   /** @test */
   public function project_members_does_not_perform_task_operations()
   {
     $task=Task::factory()->for($this->project)->create();

     $user=User::factory()->create();

     $this->project->members()->attach($user);

     $user->members()->updateExistingPivot($this->project,['active'=>true]);

      Sanctum::actingAs(
       $user,
   );

    $this->assertFalse($user->can('taskaccess', $task));    
   }

   /** @test */
   public function task_policy_check()
   { 
      $task=Task::factory()->for($this->project)->create();

      $user=User::factory()->create();

      Sanctum::actingAs(
       $user,
   );

      $response = $this->deleteJson(route('task.archive', [
        'project' => $this->project->slug,
        'task' => $task->id
    ]))->assertForbidden();
   }

   /** @test */
   public function auth_user_can_search_project_members()
   { 
      $user = User::factory()->create();

      $task=Task::factory()->create(['project_id'=>$this->project->id]);

      $this->project->members()->attach($user->id, ['active' => true]);

      $searchTerm=$user->username;

     $response = $this->getJson(route('task.members.search',
      ['project' => $this->project->slug,
      'task'=>$task->id]),
    ['search' => $searchTerm])->assertSuccessful();

     $this->assertCount(1, $response->json());
   }

   protected function assignMembersToTask(Task $task, array $members)
   {
    return $this->patchJson(route('task.assign', [
        'project' => $this->project->slug,
        'task' => $task->id,
    ]), ['members' => $members]);
   }   
}
