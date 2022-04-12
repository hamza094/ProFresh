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
         User::factory()->create([
             'email'=>'johndoe@example.org',
             'password'=>Hash::make('testpassword')
         ]);

         Sanctum::actingAs(
            User::first(),
         );
     }

    /** @test */
    public function task_requires_a_body()
    {
       $user=User::first();
       $project=Project::factory()->create(['user_id'=>$user->id]);
       $task=Task::factory()->make(['body'=>null]);
       $this->post($task->path(),$task->toArray())
          ->assertSessionHasErrors('body');
     }

     /** @test */
     public function auth_user_can_create_projects_task()
     {
       $user=User::first();
       $project=Project::factory()->create(['user_id'=>$user->id]);
       $response=$this->postJson($project->path().'/task',
           ['body' => 'My Project Task']);
       $this->assertDatabaseHas('tasks',['body'=>'My Project Task']);
   }

   /** @test */
   public function auth_user_can_not_create_same_task_twice()
   {
     $project=Project::factory()->hasTasks(1,['body'=>'Project Task'])->create();
     $this->postJson($project->path().'/task',
         ['body' => 'Project Task'])
         ->assertStatus(400);
 }

 /** @test */
 public function task_limit_per_project()
 {
   $project=Project::factory()->hasTasks(config('project.taskLimit'))->create();
   $this->postJson($project->path().'/task',
       ['body' => 'Project Task'])
       ->assertStatus(400);
}

  /** @test */
  public function auth_user_update_project_task()
  {
     $user=User::first();
     $project=Project::factory()->create(['user_id'=>$user->id]);
     $task=$project->addTask('test task');
     $this->putJson($task->path(), ['body' => 'changed']);
     $this->assertDatabaseHas('tasks',['body'=>'changed']);
 }

 /** @test */
  public function auth_user_marked_task()
  {
    $user=User::first();
    $project=Project::factory()->create(['user_id'=>$user->id]);
    $task=Task::factory()->create(['project_id'=>$project->id,'completed'=>'false']);
    $this->patchJson($task->path().'/status', ['completed' => 'true']);
    $this->assertTrue($task->completed);
  }
   /** @test */
   public function auth_user_can_delete_task()
   {
      $user=User::first();
      $project=Project::factory()->create(['user_id'=>$user->id]);
      $task=Task::factory()->create(['project_id'=>$project->id]);
      $this->deleteJson($task->path());
      $this->assertDatabaseMissing('tasks',['id'=>$task->id]);
   }

   /** @test */
   /*public function it_can_generate_paginated_links()
   {
     $user=User::first();
     $project=Project::factory()->hasTasks(config('project.taskLimit'))->create(['user_id'=>$user->id]);
     dd($this->getJson($project->path().'?page=2'));
     dd($response->project);
     //dd($response);
     //$this->assertCount(3,$project->tasks->data);
   }*/

}
