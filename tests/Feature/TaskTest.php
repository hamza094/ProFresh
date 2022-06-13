<?php

namespace Tests\Feature;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Illuminate\Testing\Fluent\AssertableJson;

class TaskTest extends TestCase
{
  use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

     public function setUp() :void
     {
         parent::setUp();
         // create a user
         $user=User::factory()->create([
             'email'=>'johndoe@example.org',
             'password'=>Hash::make('testpassword')
         ]);

         Sanctum::actingAs(
            $user,
         );

         Project::factory()->create(['user_id'=>$user->id]);
     }

    /** @test */
    public function task_requires_a_body()
    {
       $project=Project::first();

       $task=Task::factory()->make(['body'=>null]);

       $response=$this->postJson($task->path(),$task->toArray());

       $response->assertJsonMissingValidationErrors('name');
     }

     /** @test */
     public function auth_user_can_create_projects_task()
     {
       $project=Project::first();

       $response=$this->postJson($project->path().'/task',
           ['body' => 'My Project Task']);

       $this->assertDatabaseHas('tasks',['body'=>'My Project Task']);

       $response->assertJson([
           'id'=>1,
           'body'=>'My Project Task'
          ]);
   }

   /** @test */
   public function auth_user_can_not_create_same_task_twice()
   {
     $project=Project::factory(['user_id'=>User::first()->id])->hasTasks(1,['body'=>'Project Task'])->create();

     $response=$this->postJson($project->path().'/task',
         ['body' => 'Project Task'])
         ->assertStatus(422);

     $response->assertJsonValidationErrors('task');
 }

 /** @test */
 public function task_limit_per_project()
 {
   $project=Project::factory(['user_id'=>User::first()->id])->hasTasks(config('project.taskLimit'))->create();

   $response=$this->postJson($project->path().'/task',
       ['body' => 'Project Task'])
       ->assertStatus(422);

       $response->assertJsonValidationErrors('task');
}

  /** @test */
  public function auth_user_update_project_task()
  {
     $project=Project::first();

     $task=$project->addTask('test task');

     $updatedBody="Task Body Updated";

     $taskUnchanged=$this->putJson($task->path(), ['body' => $task->body]);

     $taskUnchanged->assertJson([
         'error'=>"You haven't changed anything",
        ]);

     $response=$this->putJson($task->path(), ['body' => $updatedBody]);

     $this->assertDatabaseHas('tasks',['body'=>$updatedBody]);

     $response->assertJson([
         'id'=>$task->id,
         'body'=>$updatedBody
        ]);
 }

 /** @test */
  public function auth_user_marked_task()
  {
    $project=Project::first();

    $task=Task::factory()->create(['project_id'=>$project->id,'completed'=>'false']);

    $response=$this->patchJson($task->path().'/status', ['completed' => 'true']);

    $this->assertTrue($task->completed);

    $response->assertJson([
        'completed'=>$task->completed,
       ]);
  }
   /** @test */
   public function auth_user_can_delete_task()
   {
      $project=Project::first();

      $task=Task::factory()->create(['project_id'=>$project->id]);

      $this->deleteJson($task->path())->assertNoContent($status = 204);

      $this->assertDatabaseMissing('tasks',['id'=>$task->id]);
   }

   /** @test */
   /*public function it_can_generate_paginated_links()
   {
     $user=User::first();
     $project=Project::factory()->hasTasks(config('project.taskLimit'))->create(['user_id'=>$user->id]);
     $this->getJson($project->path().'?page=2')->assertOk();
     //dd($response->project);
     //dd($response);
     //$this->assertCount(3,$project->tasks->data);
   }*/
}
