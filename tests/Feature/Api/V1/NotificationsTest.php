<?php

namespace Tests\Feature\Api\V1;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use App\Notifications\ProjectInvitation;
use App\Notifications\AcceptInvitation;
use App\Notifications\ProjectUpdated;
use App\Notifications\ProjectTask;
use App\Notifications\UserMentioned;
use Illuminate\Support\Facades\Notification;
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
       Notification::fake();

       $user=User::factory()->create();

       $this->sendInvitationToUser($this->project,$user);

       Notification::assertSentTo($user, ProjectInvitation::class);
      }


    /** @test */ 
    public function project_owner_get_notified_by_member()
    {
      Notification::fake();

      $this->project->invite($user=User::factory()->create());

      Sanctum::actingAs($user,);

      $this->getJson($this->project->path().'/accept-invitation');

      Notification::assertSentTo($this->project->user, AcceptInvitation::class);
   }


  /** @test */
  public function allowed_user_notified_on_project_update()
  {
    Notification::fake();

    $user=User::factory()->create();

    $this->addMember($this->project,$user);

    $this->patchJson($this->project->path(),['notes'=>'Project notes updated.']);

    Notification::assertSentTo($user, ProjectUpdated::class);
   } 

  /** @test */
  public function project_member_notified_when_task_added()
  {
    Notification::fake();

    $user=User::factory()->create();
 
    $this->addMember($this->project,$user);

    $this->postJson($this->project->path().'/tasks',['title'=>'new task added']);

    Notification::assertSentTo($user, ProjectTask::class);    
  }

  /** @test */
  public function mentioned_user_in_a_chat_are_notified()
  {
    Notification::fake();

    $newUser=User::factory(['username'=>'thanos844'])
          ->create();
 
      $this->addMember($this->project,$newUser);

      $response=$this
         ->postJson($this->project->path().'/conversations',['message'=>'random chat conversation with @thanos844',
        'user_id' => $this->user->id]);

      Notification::assertSentTo($newUser, UserMentioned::class);

        Notification::assertCount(1);
    }


  /** @test */
  public function user_should_not_receive_task_notification_when_adding_a_task()
  {
    Notification::fake();

    $user=User::factory()->create();

    $this->addMember($this->project,$user);

    Sanctum::actingAs($user);
     
    $this->postJson($this->project->path().'/task',['body'=>'another new task added']);

    Notification::assertNotSentTo($user, ProjectTask::class);
  }

   protected function sendInvitationToUser($project,$user)
   {
      $this->postJson($this->project->path().'/invitations',[
          'email'=>$user->email
      ]);
   }

   protected function addMember($project,$user)
   {
     $this->project
          ->members()
           ->attach($user, ['active' => true]);
   }
}
