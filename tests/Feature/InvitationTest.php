<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Project;
use Tests\TestCase;

class InvitationTest extends TestCase
{
   use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

     public function setUp() :void
     {
         parent::setUp();
         // create a user
        $user=User::factory()->create([
             'email'=>'johndoe@example.org',
             'password'=>Hash::make('testpassword')
         ]);

         Sanctum::actingAs(
             $user,
         );
     }

     /** @test */
     public function project_owner_can_invite_user()
     {
       $project=Project::factory()->create(['user_id'=>User::first()->id]);

       $InvitedUser=User::factory()->create();

       $response=$this->postJson($project->path().'/invitations',[
          'email'=>$InvitedUser->email
        ])->assertStatus(200);

        $this->assertTrue($project->members->contains($InvitedUser));

        $response->assertJson([
          'msg'=>"Project invitation sent to ".$InvitedUser->name,
         ]);
      }

        /** @test */
        public function project_owner_can_not_reinvite_user()
        {
           $project = Project::factory()->create();

           $project->invite($InvitedUser=User::factory()->create());

           $response=$this->postJson($project->path().'/invitations',[
              'email'=>$InvitedUser->email])->assertStatus(400);

            $response->assertJson([
                'error'=>"Project invitation already sent to a user",
               ]);
          }

          /** @test */
          public function auth_user_accept_project_invitation_sent_to_him()
          {
             $project=Project::factory()->create();

             $project->invite($invitedUser=User::factory()->create());

             Sanctum::actingAs(
                $invitedUser,
            );

            $response=$this->getJson($project->path().'/member')->assertStatus(200);

            $this->assertDatabaseHas('project_members', [
          "project_id" => $project->id, "user_id" =>$invitedUser->id,'active'=>true]);

          /*$response->assertJson([
              'msg'=>"You have accepted, ".$project->name." invitation",
            ]);*/
       }

       /** @test */
       public function authorized_user_can_ignore_project_invitation()
       {
         $project = Project::factory()->create(['user_id'=>User::first()->id]);

         $project->invite($InvitedUser=User::factory()->create());

         Sanctum::actingAs(
             $InvitedUser,
         );
         $this->getJson($project->path().'/ignore')->assertStatus(200);

         $this->assertDatabaseMissing('project_members', [
    "project_id" => $project->id, "user_id" => $InvitedUser->id]);

    }
    
       /** @test */
       public function project_owner_can_remove_member()
       {
          $project=Project::factory()->create(['user_id'=>User::first()->id]);

          $project->members()->attach($memberUser=User::factory()->create());

          $response=$this->getJson($project->path().'/remove/'.$memberUser->id)
          ->assertStatus(200);

          $this->assertDatabaseMissing('project_members', [
       "project_id" => $project->id, "user_id" => $memberUser->id]);

       $response->assertJson([
           'msg'=>"Member ".$memberUser->name." has been removed from a project",
          ]);
    }

}
