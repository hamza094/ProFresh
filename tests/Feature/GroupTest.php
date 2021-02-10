<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GroupTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    /** @test */
    public function chat_group_added_on_project_creation()
    {
         $this->signIn();
        $response=$this->post('api/projects',
            ['name' => 'Json','email'=>'json_pisces@outlook.com',
                'mobile'=>6785434567]);
          $this->assertDatabaseHas('groups',['id'=>1]);
          $this->assertDatabaseHas('conversations',['id'=>1]);

    }

       /** @test */
          public function project_member_add_to_chat_group(){
            $this->signIn();
            $group=create('App\Group');
              $project = create('App\Project',['group_id'=>$group->id]);
              $project->invite($user=create('App\User'));
            $this->signIn($user);
             $this->get('project/'.$project->id.'/member');
            $this->assertTrue($project->group->users->contains($user));
       }

      /** @test */
    public function authorized_user_participated_in_group_chat()
    {
      $user=create('App\User');
       $this->signIn($user);
        $group=create('App\Group');
        $project = create('App\Project',['group_id'=>$group->id,'user_id'=>$user->id]);
      $response=$this->withoutExceptionHandling()->post('/api/project/'.$project->id.'/conversations',
          ['message'=>'abra ka dabra','group_id' => $group->id,'user_id' => $user->id]);
        $this->assertDatabaseHas('conversations',['message'=>'abra ka dabra']);
    }

        /** @test */
    public function conversation_deleted_on_group_deletion()
    {
      $user=create('App\User');
       $this->signIn($user);
        $group=create('App\Group');
     $conversation=create('App\Conversation',['group_id'=>$group->id]);
     $group->delete();
      $this->assertDatabaseMissing('conversations',['id'=>$conversation->id]);
}

}