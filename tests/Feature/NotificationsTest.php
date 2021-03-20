<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NotificationsTest extends TestCase
{
  use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

     /** @test */
     public function invited_user_can_get_project_invitation_notification(){
       $user=create('App\User');
        $this->signIn($user);
        $project=create('App\Project',['user_id'=>$user->id]);
         $InvitedUser=create('App\User');
         $this->post($project->path().'/invitations',[
             'email'=>$InvitedUser->email
         ]);
        $this->assertCount(1,$InvitedUser->fresh()->notifications);
      }

      /** @test */
      public function project_owner_get_accepted_project_notification(){
        $this->signIn();
          $project = create('App\Project');
          $project->invite($user=create('App\User'));
        $this->signIn($user);
         $this->get('project/'.$project->id.'/member');
   $this->assertCount(1,$project->owner->fresh()->notifications);
   }

   /** @test */
  public function authorized_user_can_get_notification_when_project_update(){
     $this->signIn($user=create('App\User'));
     $project=create('App\Project',['user_id'=>$user->id]);
      $thomas=create('App\User');
      $this->post($project->path().'/invitations',[
          'email'=>$thomas->email
      ]);
      $this->signIn($thomas);
      $this->get('project/'.$project->id.'/member');
      $this->signIn($user);
     $this->patch($project->path(),['name'=>'john santiman','email'=>'james_picaso@outlook.com','mobile'=>'6785434567']);
     $this->assertCount(2,$thomas->fresh()->notifications);
  }

  /** @test */
  public function authorized_can_get_notification_when_task_is_added(){
     $this->signIn($user=create('App\User'));
     $project=create('App\Project',['user_id'=>$user->id]);
      $thomas=create('App\User');
      $this->post($project->path().'/invitations',[
          'email'=>$thomas->email
      ]);
      $this->signIn($thomas);
      $this->get('project/'.$project->id.'/member');
      $this->signIn($user);
      $this->post('/api/projects/'.$project->id.'/tasks',['body'=>'simpson']);
      $this->assertCount(2,$thomas->fresh()->notifications);
  }

  /** @test */
  public function authorized_can_get_notification_when_appointment_is_added(){
     $this->signIn($user=create('App\User'));
     $project=create('App\Project',['user_id'=>$user->id]);
      $thomas=create('App\User');
      $this->post($project->path().'/invitations',[
          'email'=>$thomas->email
      ]);
      $this->signIn($thomas);
      $this->get('project/'.$project->id.'/member');
      $this->signIn($user);
      $this->post('api/project/'.$project->id.'/appointment',
          ['title' => 'mine hella','location'=>'lhr pakistan','outcome'=>'Not Intrested',
        'strtdt'=>'11-20-17','strttm'=>'14:05','zone'=>'Asia/pacific','outcome'=>'Not intrested']);
      $this->assertCount(2,$thomas->fresh()->notifications);
  }
    
  /** @test */
  public function signIn_user_can_not_get_his_notification(){
     $this->signIn($user=create('App\User'));
     $project=create('App\Project',['user_id'=>$user->id]);
      $thomas=create('App\User');
      $this->post($project->path().'/invitations',[
          'email'=>$thomas->email
      ]);
      $this->signIn($thomas);
      $this->get('project/'.$project->id.'/member');
      $this->post('/api/projects/'.$project->id.'/tasks',['body'=>'simpson']);
      $this->assertCount(1,$thomas->fresh()->notifications);
  }
    

      /** @test */
 public function user_can_fetch_their_notifications()
 {
   $user=create('App\User');
    $this->signIn($user);
    $project=create('App\Project',['user_id'=>$user->id]);
     $InvitedUser=create('App\User');
     $this->post($project->path().'/invitations',[
         'email'=>$InvitedUser->email
     ]);
     $this->signIn($InvitedUser);
     $response=$this->withoutExceptionHandling()->getJson("/profile/{$InvitedUser->id}/notifications")->json();
     $this->assertCount(1,$response);
 }

 /** @test */
  public function a_user_can_clear_a_notification()
  {
    $user=create('App\User');
     $this->signIn($user);
     $project=create('App\Project',['user_id'=>$user->id]);
      $InvitedUser=create('App\User');
      $this->post($project->path().'/invitations',[
          'email'=>$InvitedUser->email
      ]);
      $this->signIn($InvitedUser);
      $this->assertCount(1,$InvitedUser->unreadNotifications);
      $notificationId=$InvitedUser->unreadNotifications->first()->id;
      $this->delete("/profile/{$InvitedUser->id}/notifications/{$notificationId}");
      $this->assertCount(0,$InvitedUser->fresh()->unreadNotifications);
  }

}