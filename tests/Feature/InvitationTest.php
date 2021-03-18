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
     public function project_owner_can_invite_user(){
       $user=create('App\User');
        $this->signIn($user);
        $project=create('App\Project',['user_id'=>$user->id]);
         $InvitedUser=create('App\User');
         $this->post($project->path().'/invitations',[
             'email'=>$InvitedUser->email
         ]);
        $this->assertTrue($project->members->contains($InvitedUser));
      }

      /** @test */
        public function project_owner_can_not_reinvite(){
          $user=create('App\User');
           $this->signIn($user);
           $project=create('App\Project',['user_id'=>$user->id]);
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
          public function authorized_signIn_user_accept_project_request(){
            $this->signIn();
              $project = create('App\Project');
              $project->invite($user=create('App\User'));
            $this->signIn($user);
             $this->get('project/'.$project->id.'/member');
             $this->assertDatabaseHas('project_members', [
       "project_id" => $project->id, "user_id" => $user->id,'active'=>1]);
       }

       /** @test */
       public function authorized_user_can_ignore_project_request(){
        $user1=create('App\User');
        $this->signIn($user1);
           $project = create('App\Project',['user_id'=>$user1->id]);
           $project->invite($user=create('App\User'));
         $this->signIn($user);
          $this->get('project/'.$project->id.'/cancel');
          $this->assertDatabaseMissing('project_members', [
    "project_id" => $project->id, "user_id" => $user->id]);
    }

       /** @test */
       public function project_owner_can_cancel_project_member_membership(){
          $user=create('App\User');
          $this->signIn($user);
          $project=create('App\Project',['user_id'=>$user->id]);
          $user2=create('App\User');
          $project->members()->attach($user2);
           $this->get('api/project/'.$project->id.'/cancel/'.$user2->id);
           $this->assertDatabaseMissing('project_members', [
       "project_id" => $project->id, "user_id" => $user2->id]);

    }

}
