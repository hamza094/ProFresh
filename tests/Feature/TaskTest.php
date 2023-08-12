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
        $status=TaskStatus::factory()->create();
 
        Task::factory(['deleted_at'=>Carbon::now()])
        ->count(3)
        ->for($this->project)
        ->create(); 

        $response = $this->getJson('/api/v1/projects/' . $this->project->slug . '/tasks?request=archived');

        $response->assertStatus(200)
                 ->assertJsonCount(3, 'tasksData')
                 ->assertJsonStructure(['message', 'tasksData']);
    }

    /** @test */
    public function allowed_user_see_active_tasks_and_paginat()
    {
        $status=TaskStatus::factory()->create();
 
        Task::factory()
        ->count(9)
        ->for($this->project)
        ->create(); 

        $response = $this->getJson('/api/v1/projects/' . $this->project->slug . '/tasks');

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
        $status=TaskStatus::factory()->create();

       $response=$this->withoutExceptionHandling()->postJson($this->project->path().'/task',['title' => 'My Project Task','status_id'=>$status->id]);

       $this->assertDatabaseHas('tasks',['title'=>'My Project Task']);

       $response->assertJson([
           "task"=>[      
           'id'=>1,
           'title'=>'My Project Task'
          ]]);
   }

   /** @test */
   public function duplicate_project_task_can_not_be_created()
   {
      $status=TaskStatus::factory()->create();

     $this->project->tasks()->create(['title'=>'Project Task']);

     $response=$this->postJson($this->project->path().'/task',
        ['title' => 'Project Task'])
        ->assertUnprocessable()
        ->assertJsonFragment([
      'errors' => ['title' => ['Task with same title already exists.']]]);

      $project2=Project::factory()->for($this->user)->create();

      $response=$this->postJson($project2->path().'/task',
         ['title' => 'Project Task'])->assertCreated();   
 }

   /** @test */
   public function task_limit_per_project()
   {
      $status=TaskStatus::factory()->create();

     Task::factory()->count(config('app.project.taskLimit'))
     ->for($this->project)->create();

     $response=$this->postJson($this->project->path().'/task',
       ['title' => 'Project Task'])
       ->assertUnprocessable()
      ->assertJsonValidationErrors('task');
}

  /** @test */
  public function allowed_user_can_update_project_task()
  {
     $status=TaskStatus::factory()->create();

     $task=$this->project->addTask('test task');

     $updatedTitle="Task title updated";

     /*$this->putJson($task->path(), ['title' => $task->title])->assertUnprocessable();*/
      $status2=TaskStatus::factory()->create();

     $response=$this->putJson($task->path(), [
      'title' => $updatedTitle,
      'description'=>'This is random project description',
      'due_at'=>'2023-07-18T14:53:23.664508Z',
      'status_id'=>$status2->id
    ])
     ->assertJson(["task"=>['id'=>$task->id,'title'=>$updatedTitle]]);

     $this->assertDatabaseHas('tasks',[
      'title'=>$updatedTitle,
      'description'=>'This is random project description',
      'due_at'=>'2023-07-18T14:53:23.664508Z',
    ]);

     $task->refresh();

    $this->assertEquals($task->status->id,$status2->id);

 }

   /** @test */
   public function members_attach_to_task()
   {
      $status=TaskStatus::factory()->create();

      $task=$this->project->addTask('test task');

      $user = $this->user;
      $members = [$user->toArray()];

      $response = $this->withoutExceptionHandling()->patchJson(route('task.members', [
            'project' => $this->project->slug,
            'task' => $task->id,
        ]), ['members' => $members]);   

       $response->assertSuccessful()
            ->assertJson([
                'message' => 'Task assigned to member Successfully',
            ]);

        $this->assertCount(1, $user->notifications);

        $this->assertDatabaseHas('task_user', [
            'task_id' => $task->id,
            'user_id' => $user->id,
        ]);
    }

        /** @test */
    public function it_unassigns_a_member_from_the_task()
    {
        $status=TaskStatus::factory()->create();

        $task=$this->project->addTask('test task');

        $task->assignee()->attach($this->user);

        // Make a request to unassign the user from the task
        $response = $this->patchJson("/api/v1/projects/{$this->project->id}/tasks/{$task->id}/unassign", [
            'member' => $this->user->id,
        ]);

        $response->assertSuccessful();

        $this->assertDatabaseMissing('task_user', [
            'task_id' => $task->id,
            'user_id' => $user->id,
        ]);

        // Assert that the response contains the success message
        $response->assertJson([
            'message' => 'Task member Unassigned',
        ]);
    }

    /** @test */
   public function allowed_user_can_archive_and_unarchive_task()
   {
        $status=TaskStatus::factory()->create();

     $task=Task::factory()->for($this->project)->create();

       $response = $this->withoutExceptionHandling()->deleteJson("/api/v1/projects/{$this->project->slug}/tasks/{$task->id}/archive");

        $this->assertSoftDeleted($task);

           $task->activities()->update(['is_hidden' => false]);

       $response = $this->getJson("/api/v1/projects/{$this->project->slug}/tasks/{$task->id}/unarchive");

      $task->refresh();

      $this->assertNotSoftDeleted($task);

      $this->assertEquals($task->deleted_at,null);
   }

   /** @test */
   public function allowed_user_can_delete_task()
   {
     $status=TaskStatus::factory()->create();

     $task=Task::factory()->for($this->project)->create();

      $this->withoutExceptionHandling()->deleteJson($task->path())->assertNoContent();

     $this->assertModelMissing($task);
   }   
}
