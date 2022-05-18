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
     public function project_owner_can_invite_user(){
       $project=Project::factory()->create(['user_id'=>User::first()->id]);
       $InvitedUser=User::factory()->create();
       $this->postJson($project->path().'/invitations',[
          'email'=>$InvitedUser->email
        ])->assertStatus(200);
        $this->assertTrue($project->members->contains($InvitedUser));
      }

        /** @test */
        public function project_owner_can_not_reinvite_user()
        {
           $project = Project::factory()->create();
           $InvitedUser = User::factory()->create();
           $project->invite($InvitedUser);
           $this->postJson($project->path().'/invitations',[
              'email'=>$InvitedUser->email])->assertStatus(400);
          }

          /** @test */
          public function authorized_user_accept_project_invitation(){
            $project=Project::factory()->create();
            $project->invite($user1=User::factory()->create());
            Sanctum::actingAs(
                $user1,
            );
            $this->getJson($project->path().'/member')->assertStatus(200);
            $this->assertDatabaseHas('project_members', [
       "project_id" => $project->id, "user_id" => $user1->id,'active'=>true]);
       }

       /** @test */
       public function authorized_user_can_ignore_project_invitation(){
         $project = Project::factory()->create(['user_id'=>User::first()->id]);
         $project->invite($user1=User::factory()->create());
         Sanctum::actingAs(
             $user1,
         );
         $this->getJson($project->path().'/ignore')->assertStatus(200);
         $this->assertDatabaseMissing('project_members', [
    "project_id" => $project->id, "user_id" => $user1->id]);
    }

       /** @test */
       public function project_owner_can_remove_member(){
          $project=Project::factory()->create(['user_id'=>User::first()->id]);
          $user1=User::factory()->create();
          $project->members()->attach($user1);
          $this->getJson($project->path().'/remove/'.$user1->id)
          ->assertStatus(200);
          $this->assertDatabaseMissing('project_members', [
       "project_id" => $project->id, "user_id" => $user1->id]);
    }

}
