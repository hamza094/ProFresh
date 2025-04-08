<?php

namespace Tests\Feature\Api\V1;

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

  // Since the project is automatically with ProjectSetup trait it should already have one activity

  /** @test */
  public function creating_a_project()
  {

    $this->assertDatabaseHas('activities', [
        'project_id'  => $this->project->id,
        'description' => 'created_project',
    ]);

    $activity = $this->project->activities()->latest()->first();
    
    $this->assertEquals('created_project',$activity->description);
  }

   /** @test */
   public function record_activity_on_updating_a_project()
   {
     $initialAttributes = $this->project->only(['name', 'slug']);

    $this->project->update(['name'=>'changed name']);

    $this->assertCount(2, $this->project->activities);

    $activity = $this->project->activities->last();

    $this->assertEquals('updated_project', $activity->description);

     $this->assertEquals([
        'before' => ['name' => $initialAttributes['name'], 'slug' => $initialAttributes['slug']],
        'after'  => ['name' => 'changed name', 'slug' => $this->project->slug],
    ], $activity->changes);
}

  /** @test */
  public function it_removes_project_activities_when_deleted()
  {
    $this->assertCount(1, $this->project->activities);

      $this->project->delete();

     $this->project->forceDelete();

    $this->assertDatabaseMissing('activities', ['project_id' => $this->project->id]);
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
    $task = $this->project->addTask('Test Task');

    $this->assertCount(2, $this->project->activities);

    $activity = $this->project->activities->last();

    $activity->refresh();

    $this->assertEquals('created_task', $activity->description);

    $this->assertInstanceOf(Task::class, $activity->subject);

    $this->assertEquals('Test Task', $activity->subject->title);
  }

   /** @test */
   public function record_on_updating_task()
   {
     $task=$this->project->addTask('test task');

     $this->putJson($task->path(), ['title' => 'changed']);

     $activity = $this->project->activities->last();

     $activity->refresh();

     $this->assertEquals('updated_task',$activity->description);

     $this->assertEquals([
          'before' => ['title' => $task->title],
          'after' =>  ['title' => 'changed']
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
   public function remove_project_task_activities_on_archived_task_deletion()
   {
      $task=$this->project->addTask('test task');

      $this->deleteJson(route('task.archive', [
        'project' => $this->project->slug,
        'task' => $task->id
      ]));

      $this->deleteJson($task->path().'/remove');

       tap($this->project->activities->last(), function ($activity) {
        $this->assertEquals('deleted_task', $activity->description);
      });       
   }


  /** @test */
  public function records_activity_when_invitation_sent_to_user()
  {
    $user=User::factory()->create();

    $this->postJson($this->project->path().'/invitations',[
        'email'=>$user->email
     ]);

    $this->assertCount(2,$this->project->activities);

    $this->assertEquals('invitation_sent',$this->project->activities->last()->description);
  }

   /** @test */
   public function records_activity_when_user_accepted_project_invitation()
   {
     $this->project->invite($user=User::factory()->create());

     Sanctum::actingAs(
         $user,
     );

    $this->getJson($this->project->path().'/accept-invitation');

    $this->assertEquals('invitation_accepted',$this->project->activities->last()->description);
  }

  /** @test */
  public function it_records_activity_when_a_project_member_is_removed()
  {
    $user=User::factory()->create();

     $this->project->members()->attach($user,['active'=>true]);

     $this->getJson($this->project->path().'/remove/member/'.$user->uuid);

    $this->assertEquals('member_removed',$this->project->activities->last()->description);
  }

  /** @test */
  public function it_records_activity_on_creating_message()
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
