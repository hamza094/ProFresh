<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Project;
use Laravel\Sanctum\Sanctum;
use App\Models\Task;
use App\Models\User;
use Tests\TestCase;

class RecordActivityTest extends TestCase
{
  use RefreshDatabase;
    /**
     * A basic feature activity example.
     *
     * @return void
     */

  /** @test */
  public function creating_a_project()
  {
    $project=projectSetup();
    $this->assertCount(1,$project->activities);
    tap($project->activities->last(), function ($activity) {
         $this->assertEquals('created_project',$activity->description);
    });
  }

   /** @test */
   public function updating_a_project()
   {
     $project=projectSetup();

     $initialName = $project->name;
     $initialSlug=$project->slug;

     $project->update(['name'=>'changed name']);

     $slug=$project->slug;
     $this->assertCount(2,$project->activities);

     tap($project->activities->last(), function ($activity) use ($initialName,$initialSlug,$slug) {

        $this->assertEquals('updated_project',$activity->description);
          $expected = [
            'before' => ['name' => $initialName,'slug'=>$initialSlug],
            'after' =>  ['name' => 'changed name','slug'=>$slug]
        ];

        $this->assertEquals($expected, $activity->changes);
    });
}

  /** @test */
  public function remove_project_activities_on_deletion()
  {
     $project=projectSetup();
     $project->forceDelete();
     $this->assertCount(0,$project->activities);
}

 /** @test */
 public function record_on_restoring_project(){
   $project=projectSetup();
   $project->delete();
   $this->getJson($project->path().'/restore')->assertStatus(200);
   $project->refresh();
   $this->assertEquals('restored_project',$project->activities->last()->description);
 }

   /** @test */
   public function record_on_creating_task()
   {
      $project=projectSetup();

      $task=$project->addTask('test task');

      $this->assertCount(2,$project->activities);

      tap($project->activities->last(), function ($activity) {
          $this->assertEquals('created_task', $activity->description);
          $this->assertInstanceOf(Task::class, $activity->subject);
          $this->assertEquals('test task',$activity->subject->body);
      });
  }

 /** @test */
 public function record_on_updating_task(){
   $project=projectSetup();

   $task=$project->addTask('test task');

   $body=$task->body;

   $this->putJson($task->path(), ['body' => 'changed']);

   tap($project->activities->last(), function ($activity) use ($body) {
      $this->assertEquals('updated_task',$activity->description);
        $expected = [
          'before' => ['body' => $body,'completed'=>false],
          'after' =>  ['body' => 'changed']
      ];
      $this->assertEquals($expected, $activity->changes);
  });
}

   /** @test */
   public function record_on_task_deletion()
   {
     $project=projectSetup();
     $task=$project->addTask('test task');
     $task->delete();
     $this->assertCount(3,$project->activities);
     $this->assertEquals('deleted_task',$project->activities->last()->description);
   }

   /** @test */
   /*public function remove_project_task_activities_on_deletion()
   {
      $project=projectSetup();

 
   }*/

/** @test */
public function invitation_sent_to_user(){
    $project=projectSetup();
    $user=User::factory()->create();

    $this->postJson($project->path().'/invitations',[
        'email'=>$user->email
    ]);

   $this->assertCount(2,$project->activities);
   $this->assertEquals('sent_invitation_member',$project->activities->last()->description);
 }

 /** @test */
 public function user_accept_project_invitation(){
     $project=projectSetup();
     $project->invite($user=User::factory()->create());

     Sanctum::actingAs(
         $user,
     );

    $this->getJson($project->path().'/accept-invitation');
    $this->assertEquals('accept_invitation_member',$project->activities->last()->description);
}

  /** @test */
  public function canceling_project_membership(){
     $project=projectSetup();
     $user=User::factory()->create();

     $project->members()->attach($user);

     $this->getJson($project->path().'/remove/'.$user->id);
    $this->assertEquals('remove_project_member',$project->activities
      ->last()->description);
  }

  /** @test */
  public function record_on_message_creation(){
      $project=projectSetup();
      $response=$this->postJson($project->path().'/message',[
        'message'=>'this is project message',
        'users'=>json_encode([User::first()->id]),
        'subject'=>'this is message subject',
        'sms'=>true,
        'mail'=>true,
      ]);
      $this->assertCount(3,$project->activities);
      $this->assertEquals('created_message',$project->activities->last()->description);

  }

}
