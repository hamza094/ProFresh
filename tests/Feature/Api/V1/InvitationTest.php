<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use App\Traits\ProjectSetup;
use App\Models\User;
use Tests\TestCase;

class InvitationTest extends TestCase
{
   use RefreshDatabase,ProjectSetup;

     /** @test */
     public function project_owner_can_invite_user()
     {
        $InvitedUser=User::factory()->create();

        $response=$this->postJson($this->project->path().
         '/invitations',
        [
          'email'=>$InvitedUser->email
        ])->assertOk()
          ->assertJson([
          'message'=>"Project invitation sent to {$InvitedUser->name}",
         ]);

        $this->assertTrue($this->project->members->contains(
            $InvitedUser));
      }

    /** @test */
    public function project_owner_can_not_reinvite_user_and_himself()
    {
      $invitedUser = User::factory()->create();
      $this->project->invite($invitedUser);

      $response=$this->postJson($this->project->path().'/invitations',[
            'email'=>$invitedUser->email
          ])->assertUnprocessable()
            ->assertJsonValidationErrors('invitation');

        $response=$this->postJson($this->project->path().
            '/invitations',
            ['email'=>$this->project->user->email])
        ->assertUnprocessable()
        ->assertJsonValidationErrors('invitation');
    }

    /** @test */
    public function auth_user_accept_project_invitation_sent_to_him()
    {
      $invitedUser = User::factory()->create();
      $this->project->invite($invitedUser);

      Sanctum::actingAs($invitedUser);

      $response=$this->getJson($this->project->path().
          '/accept-invitation')
          ->assertOk()
          ->assertJson([
              'message'=>"You have accepted Project invitation",
              'project'=>['id'=>$this->project->id]
          ]);

      $this->assertDatabaseHas('project_members', [
        "project_id" => $this->project->id, 
        "user_id" =>$invitedUser->id,
        'active'=>true
        ]);
      }

       /** @test */
      public function authorized_user_can_ignore_project_invitation()
      {
        $invitedUser = User::factory()->create();
        $this->project->invite($invitedUser);

        Sanctum::actingAs($invitedUser);

        $this->getJson($this->project->path().'/ignore')
         ->assertOk()
         ->assertJson([
            'message'=>"You have rejected the project request to join",
            'project'=>['id'=>$this->project->id]
          ]);

        $this->assertDatabaseMissing('project_members', [
          "project_id" => $this->project->id,
           "user_id" =>$invitedUser->id
        ]);
      }

      /** @test */
      public function project_owner_can_remove_member()
      {
        $memberUser=User::factory()->create();
        $this->project->members()->attach($memberUser);

          $response=$this->getJson($this->project->path().'/remove/'.$memberUser->id)
            ->assertOk()
            ->assertJson([
            'message'=>"Member {$memberUser->name} has been removed from the project",
          ]);

          $this->assertDatabaseMissing('project_members', [
            "project_id" => $this->project->id,
            "user_id" => $memberUser->id
        ]);
      }

}
