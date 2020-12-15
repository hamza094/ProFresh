<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InvitationTest extends TestCase
{
  use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

     /** @test */
     public function a_signIn_can_invite_user(){
         $this->signIn();
         $project=create('App\Project');
         $InvitedUser=create('App\User');
         $this->withoutExceptionHandling()->post($project->path().'/invitations',[
             'email'=>$InvitedUser->email
         ]);
        $this->assertTrue($project->members->contains($InvitedUser));
      }

      /** @test */
        public function a_user_can_not_reinvite(){
            $this->signIn();
            $project=create('App\Project');
            $InvitedUser=create('App\User');
            $this->post($project->path().'/invitations',[
                'email'=>$InvitedUser->email]);
           $this->assertTrue($project->members->contains($InvitedUser));
             $this->assertCount(1,$project->members);
             $this->withoutExceptionHandling()->post($project->path().'/invitations',[
                'email'=>$InvitedUser->email]);
            $this->assertCount(1,$project->members);
          }

          /** @test */
          public function a_signIn_user_accept_project_request(){
            $this->signIn();
              $project = create('App\Project');
              $project->invite($user=create('App\User'));
            $this->signIn($user);
             $this->withoutExceptionHandling()->get('project/'.$project->id.'/member');
             $this->assertDatabaseHas('project_members', [
       "project_id" => $project->id, "user_id" => $user->id,'active'=>1]);
       }

}
