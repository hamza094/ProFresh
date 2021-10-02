<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskTest extends TestCase
{
  use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

     /** @test */
     public function task_requires_a_body(){
        $user=create('App\Models\User');
    $this->signIn($user);
    $project=create('App\Models\Project',['user_id'=>$user->id]);
         $task=make('App\Models\Task',['body'=>null]);
          $this->post('api/project/'.$project->id.'/task',$task->toArray())
            ->assertSessionHasErrors('body');
     }

     /** @test */
     public function a_project_can_have_a_task()
     {
       $user=create('App\Models\User');
        $this->signIn($user);
        $project=create('App\Models\Project',['user_id'=>$user->id]);
      $task=create('App\Models\Task');
      $this->post($task->path(),$task->toArray());
      $this->assertDatabaseHas('tasks',['body'=>$task->body]);
      //$this->get($project->path())->assertSee($task->body);
   }

   /** @test */
  /*  public function only_the_owner_can_update_tasks(){
      $this->signIn();
      $project=create('App\Project');
      $task=$project->addTask('test task');
      $this->patch($task->path(), ['body' => 'changed','completed'=>true])
          ->assertStatus(403);
      $this->assertDatabaseMissing('tasks',['body'=>'changed','completed'=>true]);

  }*/

   /** @test */
 public function task_marked_as_completed(){
   $user=create('App\Models\User');
    $this->signIn($user);
    $project=create('App\Models\Project',['user_id'=>$user->id]);
     $task=$project->addTask('test task');
     $this->patch($task->path(), ['body' => 'changed','completed'=>true]);
     $this->assertDatabaseHas('tasks',['body'=>'changed','completed'=>true]);
 }

 /** @test */
public function task_marked_as_incomplete(){
  $user=create('App\Models\User');
   $this->signIn($user);
   $project=create('App\Models\Project',['user_id'=>$user->id]);
 $task=$project->addTask('test task');
 $this->patch($task->path(), ['body' => 'changed','completed'=>true]);
  $this->patch($task->path(), ['body' => 'changed','completed'=>false]);
 $this->assertDatabaseHas('tasks',['body'=>'changed','completed'=>false]);
}

/** @test */
   public function signIn_user_can_delete_task(){
      $user=create('App\Models\User');
      $this->signIn($user);
      $project=create('App\Models\Project',['user_id'=>$user->id]);
      $task=create('App\Models\Task',['project_id'=>$project->id]);
      $this->withoutExceptionHandling()->delete($task->path());
      $this->assertDatabaseMissing('tasks',['id'=>$task->id]);
   }




}
