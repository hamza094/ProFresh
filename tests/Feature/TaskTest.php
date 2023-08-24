<?php

namespace Tests\Feature;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
    public function allowed_user_see_active_tasks_and_paginat()
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
          'status_id'=>$this->status->id])
          ->assertCreated()
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
     $this->project->tasks()->create(['title'=>'Project Task']);

     $response=$this->postJson($this->project->path().'/tasks',
        ['title' => 'Project Task'])
         ->assertJsonValidationErrors('title');

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

     $status2=TaskStatus::factory()->create();

     $response=$this->putJson($task->path(), [
      'title' => $updatedTitle,
      'description'=>'This is random project description',
      'due_at'=>Carbon::today()->addDays(5),
      'status_id'=>$status2->id
    ])
     ->assertJson(["task"=>['id'=>$task->id,'title'=>$updatedTitle]]);

    $task->refresh();

     $this->assertDatabaseHas('tasks',[
      'title'=>$updatedTitle,
      'description'=>'This is random project description',
      'due_at'=>Carbon::today()->addDays(5),
    ])
     ->assertEquals($task->status->id,$status2->id);
    }

   /** @test */
   public function members_assign_to_task()
   {
      $task=$this->project->addTask('test task');

      $user = $this->user;
      $members = [$user->id];

     $user->members()->syncWithoutDetaching([$this->project->id => ['active' => true]]);

      $this->assignMembersToTask($task, $members)
            ->assertSuccessful()
            ->assertJson([
                'message' => 'Task assigned to member Successfully',
            ]);

        //$this->assertCount(1, $user->notifications);

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

       $response = $this->deleteJson(route('task.archive', [
        'project' => $this->project->slug,
        'task' => $task->id
    ]));

        $this->assertSoftDeleted($task);

        //$task->activities()->update(['is_hidden' => false]);

    $response = $this->getJson(route('task.unarchive', [
        'project' => $this->project->slug,
        'task' => $task->id,
    ]));

      $task->refresh();

      $this->assertNotSoftDeleted($task);

      $this->assertEquals($task->deleted_at,null);
   }

   /** @test */
   public function allowed_user_can_delete_task()
   {
     $task=Task::factory()->for($this->project)->create();

      $this->withoutExceptionHandling()->deleteJson($task->path())->assertNoContent();

     $this->assertModelMissing($task);
   }

   protected function assignMembersToTask(Task $task, array $members)
   {
    return $this->patchJson(route('task.assign', [
        'project' => $this->project->slug,
        'task' => $task->id,
    ]), ['members' => $members]);
   }   
}
