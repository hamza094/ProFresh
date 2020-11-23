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
         $this->signIn();
         $lead=create('App\Lead',['user_id'=>auth()->id()]);
         $task=make('App\Task',['body'=>null]);
         $this->post($lead->path().'/tasks',$task->toArray())
             ->assertSessionHasErrors('body');
     }

     /** @test */
     public function a_lead_can_have_a_task()
     {
       $this->signIn();
      $lead=create('App\Lead',['user_id'=>auth()->id()]);
      $task=create('App\Task');
      $this->withoutExceptionHandling()->post($lead->path().'/tasks',$task->toArray());
      $this->assertDatabaseHas('tasks',['body'=>$task->body]);
      //$this->withoutExceptionHandling()->get($lead->path())->assertSee($task->body);
   }

   /** @test */
  /*  public function only_the_owner_can_update_tasks(){
      $this->signIn();
      $lead=create('App\Lead');
      $task=$lead->addTask('test task');
      $this->patch($task->path(), ['body' => 'changed','completed'=>true])
          ->assertStatus(403);
      $this->assertDatabaseMissing('tasks',['body'=>'changed','completed'=>true]);

  }*/

   /** @test */
 public function task_marked_as_completed(){
     $this->signIn();
     $lead=create('App\Lead');
     $task=$lead->addTask('test task');
     $this->withoutExceptionHandling()->patch($task->path(), ['body' => 'changed','completed'=>true]);
     $this->assertDatabaseHas('tasks',['body'=>'changed','completed'=>true]);
 }

 /** @test */
public function task_marked_as_incomplete(){
 $this->signIn();
 $lead=create('App\Lead');
 $task=$lead->addTask('test task');
 $this->patch($task->path(), ['body' => 'changed','completed'=>true]);
  $this->patch($task->path(), ['body' => 'changed','completed'=>false]);
 $this->assertDatabaseHas('tasks',['body'=>'changed','completed'=>false]);
}

/** @test */
   public function signIn_user_can_delete_task(){
      $this->signIn();
      $lead=create('App\Lead');
      $task=create('App\Task');
      $this->withoutExceptionHandling()->delete($task->path());
      $this->assertDatabaseMissing('tasks',['id'=>$task->id]);
   }




}
