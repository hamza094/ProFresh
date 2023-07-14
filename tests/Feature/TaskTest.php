<?php

namespace Tests\Feature;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Traits\ProjectSetup;
use App\Models\Project;
use App\Models\TaskStatus;
use Tests\TestCase;
use App\Models\Task;

class TaskTest extends TestCase
{
  use RefreshDatabase,ProjectSetup;


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
     $task=$this->project->addTask('test task');

     $updatedBody="Task Body Updated";

     $taskUnchanged=$this->putJson($task->path(), ['body' => $task->body]);

     $taskUnchanged->assertJson([
         'error'=>"You haven't changed anything",
        ]);

     $response=$this->putJson($task->path(), ['body' => $updatedBody]);

     $this->assertDatabaseHas('tasks',['body'=>$updatedBody]);

     $response->assertJson([
       "task"=>[      
         'id'=>$task->id,
         'body'=>$updatedBody]
       ]);
 }

   /** @test */
   public function allowed_user_can_marked_task()
   {
     $task=$task=Task::factory()->for($this->project)
           ->create(['completed'=>false]);

     $response=$this->patchJson($task->path().'/status', ['completed' =>true]);

     $task->refresh();

     $this->assertTrue($task->completed);

     $response->assertJson([
       "task"=>['completed'=>$task->completed]
       ]);
    }

   /** @test */
   public function allowed_user_can_delete_task()
   {
     $task=Task::factory()->for($this->project)->create();

      $this->withoutExceptionHandling()->deleteJson($task->path())->assertNoContent();

     $this->assertModelMissing($task);
   }

   
   public function it_can_generate_paginated_links()
   {
     $project=Project::factory()->for($this->user)
     ->hasTasks(config('project.taskLimit'))->create();

     $response=$this->getJson($project->path().'?page=2')
     ->assertOk();

     $getResponse=$response->json()['tasks'];

     $this->assertEquals($getResponse['meta']['current_page'],2);

     $this->assertEquals($getResponse['data'][0]['id'],4);

     $this->assertEquals(count(collect($getResponse['data'])),3);
   }
}
