<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use App\Traits\ProjectSetup;
use App\Models\User;
use Tests\TestCase;

class NotificationsTest extends TestCase
{
  use RefreshDatabase,ProjectSetup;
    /**
     * A notification feature test.
     *
     * @return void
     */


     /** @test */
     public function invited_user_can_get_project_invitation()
     {
       $user=User::factory()->create();

       $this->send_invitation_to_user($this->project,$user);

       $this->assertCount(1,$user->notifications);
      }


    /** @test */ 
    public function project_owner_get_notified_by_member()
    {
      $this->project->invite($user=User::factory()->create());

      Sanctum::actingAs($user,);

      $this->get($this->project->path().'/accept-invitation');

      $this->assertCount(1,$this->project->user->notifications);
   }


  /** @test */
  public function allowed_user_notified_on_project_update()
  {
    $user=User::factory()->create();

    $this->add_user_to_become_project_member($this->project,$user);

    $this->patchJson($this->project->path(),['notes'=>'Project notes updated.']);

    $this->assertCount(1,$user->notifications);

    $notification=$user->notifications[0];

    $this->assertEquals("App\Notifications\ProjectUpdated",$notification->type);

    $this->assertEquals($user->id,$notification->notifiable_id);


  } 



  /** @test */
  public function project_member_notified_when_task_added()
  {
    $user=User::factory()->create();
 
    $this->add_user_to_become_project_member($this->project,$user);

    $this->postJson($this->project->path().'/task',['body'=>'new task added']);

    $this->assertCount(1,$user->notifications);

    $notification=$user->notifications[0];

    $this->assertEquals("App\Notifications\ProjectTask",$notification->type);

    $this->assertEquals($user->id,$notification->notifiable_id);
  }


  /** @test */
  public function user_wont_get_his_perform_function()
  {
    $user=User::factory()->create();

    $this->add_user_to_become_project_member($this->project,$user);

    Sanctum::actingAs($user);
     
    $this->postJson($this->project->path().'/task',['body'=>'another new task added']);

    $this->assertCount(0,$user->fresh()->notifications);
  }


  /** @test */
  public function auth_user_can_fetch_their_notifications()
  {
    $user=User::factory()->create();

    $this->send_invitation_to_user($this->project,$user);

    Sanctum::actingAs($user,);

    $response=$this->getJson("/api/v1/user/{$user->id}/notifications");

    $this->assertCount(1,$response->json());
 }


  /** @test */
  public function a_user_can_clear_a_notification()
  {
     $user=User::factory()->create();

     $this->send_invitation_to_user($this->project,$user);

     Sanctum::actingAs($user,);

     $this->assertCount(1,$user->unreadNotifications);

     $notificationId=$user->unreadNotifications->first()->id;

     $response=$this->deleteJson("/api/v1/user/{$user->id}/notifications/{$notificationId}");

     $this->assertCount(0,$user->fresh()->unreadNotifications);
   }

   protected function send_invitation_to_user($project,$user)
   {
      $this->postJson($this->project->path().'/invitations',[
          'email'=>$user->email
      ]);
   }


   protected function add_user_to_become_project_member($project,$user)
   {
     $this->project->members()->attach($user);

     \DB::table('project_members')
     ->where('project_id', $this->project->id)
     ->where('user_id', $user->id)
     ->update(['active' =>true]);
   }
}
