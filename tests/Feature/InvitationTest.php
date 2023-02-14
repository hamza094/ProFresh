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
        ])->assertOk();

        $this->assertTrue($this->project->members->contains(
            $InvitedUser));

        $response->assertJson([
          'message'=>"Project invitation sent to ".$InvitedUser->name,
         ]);
      }


        /** @test */
    public function project_owner_can_not_reinvite_user_and_himself()
    {
      $this->project->invite($InvitedUser=User::factory()->create());

      $response=$this->postJson($this->project->path().'/invitations',[
            'email'=>$InvitedUser->email
          ])->assertUnprocessable();

        $response->assertJsonValidationErrors('invitation');

        $response=$this->postJson($this->project->path().
            '/invitations',
            ['email'=>$this->project->user->email])
        ->assertUnprocessable();

        $response->assertJsonValidationErrors('invitation');
    }

    /** @test */
    public function auth_user_accept_project_invitation_sent_to_him()
    {
      $this->project->invite($invitedUser=User::factory()->create());

        Sanctum::actingAs($invitedUser,);

        $response=$this->getJson($this->project->path().
            '/accept-invitation')->assertOk();

            $this->assertDatabaseHas('project_members', 
            ["project_id" => $this->project->id, "user_id" =>
              $invitedUser->id,'active'=>true]);


          $response->assertJson([
              'message'=>"You have accepted, ".$this->project->name." invitation",
            ]);
       }

       /** @test */
       public function authorized_user_can_ignore_project_invitation()
       {
         $this->project->invite($InvitedUser=User::factory()->create());

        Sanctum::actingAs($InvitedUser,);

         $this->getJson($this->project->path().'/ignore')
         ->assertOk();

         $this->assertDatabaseMissing('project_members', 
            ["project_id" => $this->project->id, "user_id" => 
              $InvitedUser->id]);
         }

       /** @test */
       public function project_owner_can_remove_member()
       {
          $this->project->members()->attach($memberUser=
            User::factory()->create());

          $response=$this->getJson($this->project->path().'/remove/'.$memberUser->id)->assertOk();

          $this->assertDatabaseMissing('project_members', 
            ["project_id" => $this->project->id, "user_id" => 
            $memberUser->id]);

         $response->assertJson([
            'message'=>"Member ".$memberUser->name." has been removed from a project",
           ]);
    }

}
