<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Traits\ProjectSetup;
use Laravel\Sanctum\Sanctum;
use App\Models\Task;
use App\Models\User;
use Tests\TestCase;

class RecordActivityTest extends TestCase
{
  use RefreshDatabase,ProjectSetup;

  /** @test */
  public function creating_a_project()
  {
    $this->assertCount(1,$this->project->activities);

    tap($this->project->activities->last(), function ($activity) {
         $this->assertEquals('created_project',$activity->description);
    });
  }

   /** @test */
   public function updating_a_project()
   {
     $initialName = $this->project->name;
     $initialSlug = $this->project->slug;

    $this->project->update(['name'=>'changed name']);

    $this->assertCount(2, $this->project->activities);
    $activity = $this->project->activities->last();

    $this->assertEquals('updated_project', $activity->description);
    $this->assertEquals([
        'before' => ['name' => $initialName, 'slug' => $initialSlug],
        'after' =>  ['name' => 'changed name', 'slug' => $this->project->slug]
    ], $activity->changes);
}

  /** @test */
  public function remove_project_activities_on_deletion()
  {
     $this->project->forceDelete();

     $this->assertCount(0,$this->project->activities);
  }

  /** @test */
  public function record_on_restoring_project()
  {
    $this->project->delete();

    $this->getJson($this->project->path().'/restore')->assertOk();

    $this->project->refresh();

    $this->assertEquals('restored_project',
      $this->project->activities->last()->description);
 }

   /** @test */
   public function record_on_creating_task()
   {
    $task = $this->project->addTask('test task');

    $this->assertCount(2, $this->project->activities);
    $activity = $this->project->activities->last();

    $this->assertEquals('created_task', $activity->description);
    $this->assertInstanceOf(Task::class, $activity->subject);
    $this->assertEquals('test task', $activity->subject->body);
  }

   /** @test */
   public function record_on_updating_task()
   {
     $task=$this->project->addTask('test task');
     $body=$task->body;

     $this->putJson($task->path(), ['body' => 'changed']);

     $activity = $this->project->activities->last();
     $this->assertEquals('updated_task',$activity->description);

     $this->assertEquals([
          'before' => ['body' => $body,'completed'=>false],
          'after' =>  ['body' => 'changed']
      ], $activity->changes);
  }

   /** @test */
   public function record_on_task_deletion()
   {
     $task=$this->project->addTask('test task');

     $task->delete();

     $this->assertCount(3,$this->project->activities);

     $this->assertEquals('deleted_task',$this->project->activities->last()->description);
   }

   /** @test */
   public function remove_project_task_activities_on_deletion()
   {
      $task=$this->project->addTask('test task');

      $this->deleteJson($task->path());

       tap($this->project->activities->last(), function ($activity) {
        $this->assertEquals('deleted_task', $activity->description);
      });       
   }


  /** @test */
  public function invitation_sent_to_user()
  {
    $user=User::factory()->create();

    $this->postJson($this->project->path().'/invitations',[
        'email'=>$user->email
     ]);

    $this->assertCount(2,$this->project->activities);

    $this->assertEquals('sent_invitation_member',$this->project->activities->last()->description);
  }

   /** @test */
   public function user_accept_project_invitation()
   {
     $this->project->invite($user=User::factory()->create());

     Sanctum::actingAs(
         $user,
     );

    $this->getJson($this->project->path().'/accept-invitation');

    $this->assertEquals('accept_invitation_member',$this->project->activities->last()->description);
  }

  /** @test */
  public function canceling_project_membership()
  {
    $user=User::factory()->create();

     $this->project->members()->attach($user);

     $this->getJson($this->project->path().'/remove/'.$user->id);

    $this->assertEquals('remove_project_member',$this->project->activities->last()->description);
  }

  /** @test */
  public function record_on_message_creation()
  {
    $response=$this->postJson($this->project->path().'/message',[
        'message'=>'this is project message',
        'users'=>json_encode([User::first()->id]),
        'subject'=>'this is message subject',
        'sms'=>true,
        'mail'=>true,
      ]);

      $this->assertCount(3,$this->project->activities);

      $this->assertEquals('created_message',$this->project->activities->last()->description);
  }

}
