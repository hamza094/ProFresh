<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
  $this->signIn();
    $project=create('App\Models\Project');
    $this->assertCount(1,$project->activity);
   tap($project->activity->last(), function ($activity) {
         $this->assertEquals('created_project',$activity->description);
        $this->assertNull($activity->changes);
    });
}

/** @test*/
 public function updating_a_project()
{
  $this->signIn();
    $project=create('App\Models\Project');
    $originalName = $project->name;
    $project->update(['name'=>'changed']);
    $this->assertCount(2,$project->activity);
    tap($project->activity->last(), function ($activity) use ($originalName) {
        $this->assertEquals('updated_project',$activity->description);
          $expected = [
            'before' => ['name' => $originalName],
            'after' => ['name' => 'changed']
        ];
        $this->assertEquals($expected, $activity->changes);
    });
}

/** @test */
public function deleting_project_remove_all_project_related_activities()
{
  $user=create('App\Models\User');
   $this->signIn($user);
   $project=create('App\Models\Project',['user_id'=>$user->id]);
 $this->get('api/projects/'.$project->id.'/delete');
$this->assertCount(0,$project->activity);
}


/** @test */
public function creating_a_task(){
    $this->signIn();
    $project=create('App\Models\Project',['user_id'=>auth()->id()]);
    $task=$project->addTask('test task');
    $this->assertCount(2,$project->activity);
   tap($project->activity->last(), function ($activity) {
        $this->assertEquals('created_task', $activity->description);
        $this->assertInstanceOf('App\Models\Task', $activity->subject);
       $this->assertEquals('test task',$activity->subject->body);
     });
}

/** @test */
public function updating_a_task(){
   $this->signIn();
   $project=create('App\Models\Project',['user_id'=>auth()->id()]);
   $task=$project->addTask('test task');
   $this->patch($task->path(), ['body' => 'changed','completed'=>true]);
   $this->assertCount(4,$project->activity);
   tap($project->activity->last(), function ($activity) {
       $this->assertEquals('updated_task',$activity->description);
       $this->assertInstanceOf('App\Task', $activity->subject);
      $this->assertEquals('changed',$activity->subject->body);
    });
}

/** @test */
public function deleting_a_task(){
$this->signIn();
$project=create('App\Models\Project',['user_id'=>auth()->id()]);
$task=$project->addTask('test task');
$task->delete();
$this->assertCount(3,$project->activity);
$this->assertEquals('deleted_task',$project->activity->last()->description);
}

/** @test */
public function creating_an_appointment(){
  $this->signIn();
  $project=create('App\Models\Project');
  $appointment=create('App\Models\Appointment',['title'=>'My Appointment','project_id'=>$project->id]);
    $this->assertCount(2,$project->activity);
    tap($project->activity->last(), function ($activity) {
         $this->assertEquals('created_appointment', $activity->description);
         $this->assertInstanceOf('App\Appointment', $activity->subject);
        $this->assertEquals('My Appointment',$activity->subject->title);
      });
}

/** @test */
public function updating_an_appointment(){
  $user=create('App\User');
   $this->signIn($user);
   $project=create('App\Models\Project',['user_id'=>$user->id]);
 $appointment=create('App\Models\Appointment',['title'=>'My Appointment','project_id'=>$project->id]);
 $this->patch('/api/project/'.$project->id.'/appointment/'.$appointment->id,
 ['title'=>'mine appoint','location'=>'pakistan','outcome'=>'Intrested','strtdt'=>'11-20-17','strttm'=>'14:05','zone'=>'Asia/pacific','outcome'=>'Not intrested']);
  $this->assertCount(4,$project->activity);
  tap($project->activity->last(), function ($activity) {
      $this->assertEquals('updated_appointment',$activity->description);
      $this->assertInstanceOf('App\Models\Appointment', $activity->subject);
     $this->assertEquals('mine appoint',$activity->subject->title);
   });
}

/** @test */
public function deleting_an_appointment(){
  $this->signIn();
  $project=create('App\Models\Project');
  $appointment=create('App\Models\Appointment',['title'=>'My Appointment','project_id'=>$project->id]);
  $appointment->delete();
$this->assertCount(3,$project->activity);
$this->assertEquals('deleted_appointment',$project->activity->last()->description);
}

/** @test */
public function invitation_sent_to_user(){
  $user=create('App\Models\User');
   $this->signIn($user);
   $project=create('App\Models\Project',['user_id'=>$user->id]);
    $InvitedUser=create('App\User');
    $this->post($project->path().'/invitations',[
        'email'=>$InvitedUser->email
    ]);
   $this->assertCount(2,$project->activity);
   $this->assertEquals('sent_member_project',$project->activity->last()->description);
 }

/** @test */
 public function user_accept_project_invitation(){
   $this->signIn();
     $project = create('App\Models\Project');
     $project->invite($user=create('App\Models\User'));
   $this->signIn($user);
    $this->get('project/'.$project->id.'/member');
$this->assertCount(2,$project->activity);
$this->assertEquals('accept_member_project',$project->activity->last()->description);
}

/** @test */
  public function canceling_project_membership(){
    $user=create('App\Models\User');
    $this->signIn($user);
    $project=create('App\Models\Project',['user_id'=>$user->id]);
    $user2=create('App\Models\User');
    $project->members()->attach($user2);
     $this->get('api/project/'.$project->id.'/cancel/'.$user2->id);
     $this->assertDatabaseMissing('project_members', [
    "project_id" => $project->id, "user_id" => $user2->id]);
    $this->assertCount(2,$project->activity);
    $this->assertEquals('cancel_member_project',$project->activity->last()->description);
  }



}
