<?php

namespace Tests\Feature\Api\V1;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\Sanctum;
use App\Models\User;
use Tests\TestCase;
use App\Traits\ProjectSetup;
use App\Enums\NotificationFilter;

class UserNotificationsTest extends TestCase
{   
    use RefreshDatabase, ProjectSetup;

    /** @test */
    public function auth_user_can_fetch_there_notifications()
    {
        $user = $this->actingAsInvitedUser();
    
        $response=$this->getJson("/api/v1/notifications");
    
        $this->assertCount(1, $response->json('data'));
    }

    /** @test */
    public function auth_user_can_fetch_notifications_by_status()
    {
        $user = $this->actingAsInvitedUser();

        $unreadResponse = $this->getJson('/api/v1/notifications?filter=' . NotificationFilter::UNREAD->value);
        $this->assertCount(1, $unreadResponse->json('data'));

        $user->notifications()->latest()->first()->markAsRead();
        $readResponse = $this->getJson('/api/v1/notifications?filter=' . NotificationFilter::READ->value);
        $this->assertCount(1, $readResponse->json('data'));
    }

    /** @test */
    public function auth_user_can_mark_all_notifications_as_read()
    {
        $user = User::factory()->create();

        // Create a read notification
        $this->sendInvitationToUser($this->project,$user);
        $this->addMember($this->project,$user);
        $this->postJson($this->project->path().'/tasks',['title'=>'new task added']);
        Sanctum::actingAs($user);

        $response = $this->withoutExceptionHandling()->getJson('/api/v1/notifications/mark-all-read');

        $response->assertStatus(200);
        $this->assertCount(0, $user->fresh()->unreadNotifications);
    }

    /** @test */
    public function auth_user_can_delete_a_notification()
    {
        $user = $this->actingAsInvitedUser();

        $notification=$user->notifications()->latest()->first();

        $response = $this->deleteJson('/api/v1/notifications/' . $notification->id);

        $response->assertStatus(200);
        $response->assertJson(['message' => 'Notification deleted successfully.']);
        $this->assertCount(0, $user->fresh()->notifications);
    }

    /** @test */
    public function auth_user_can_update_notification_status()
    {
        $user = $this->actingAsInvitedUser();

        $notification=$user->notifications()->latest()->first();

        // Update status to read
        $response = $this->patchJson("/api/v1/notifications/{$notification->id}/status", ['status' => 'read']);
        $this->assertNotNull($notification->fresh()->read_at);

        // Update status to unread
        $response = $this->patchJson("/api/v1/notifications/{$notification->id}/status", ['status' => 'unread']);
        $this->assertNull($notification->fresh()->read_at);
    }

    protected function sendInvitationToUser($project,$user)
    {
       $this->postJson($this->project->path().'/invitations',[
           'email'=>$user->email
       ]);
    }

    protected function actingAsInvitedUser(): User
    {
        $user = User::factory()->create();
        $this->sendInvitationToUser($this->project, $user);
        Sanctum::actingAs($user);
        return $user;
    }

    public function projectUpdate($project,$user){
        $this->patchJson($project->path(),['notes'=>'Project notes updated.']);
    }


    protected function addMember($project,$user)
   {
     $this->project
          ->members()
           ->attach($user, ['active' => true]);
   }
}