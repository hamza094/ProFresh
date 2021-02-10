<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProfileTest extends TestCase
{
  use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

     /** @test */
     public function sign_user_see_his_profile(){
       $this->signIn();
       $user=create('App\User');
       $this->get('users/'.$user->id.'/profile')->assertSee($user->name);
     }

    /** @test */     
    public function avatar_can_be_added_by_profile_owner()
    {

        $this->json('POST','api/user/1/avatar')
            ->assertStatus(401);
    }

    /** @test */
    public function a_valid_avatar_must_be_provided(){
      $user=create('App\User');
       $this->signIn($user);
        $this->json('POST','api/user/'.$user->id.'/avatar',[
            'avatar'=>'not-an-image'
        ])->assertStatus(422);
    }


   
    public function authorize_user_may_add_avatar_to_project()
    {
      $user=create('App\User');
       $this->signIn($user);
        Storage::fake('s3');
        $this->json('POST','api/user/'.$user->id.'/avatar',[
            'avatar_path'=>$file=UploadedFile::fake()->image('avatar.jpg')
        ]);

        Storage::disk('s3')->assertExists('avatars/'.$file->hashName());
    }

    /** @test */
    public function a_user_can_determine_their_avatar_path()
    {
      $user=create('App\User');
       $this->signIn($user);
        $user->avatar_path='http://localhost/storage/avatars/me.jpg';
        $this->assertEquals(asset('storage/avatars/me.jpg'),$user->avatar_path);
    }


        /** @test */
         public function profile_owner_can_delete_his_avatar(){
           $user=create('App\User',['avatar_path'=>'https://encrypted-tbn0.gstatic.com']);
            $this->signIn($user);
            $this->patch('api/user/'.$user->id.'/avatar-delete');
            $this->assertDatabaseHas('users',['avatar_path'=>null]);
         }


        /** @test */
        public function profile_owner_can_update_his_profile(){
        $user=create('App\User');
        $this->signIn($user);
        $Updatedname='Assemble';
        $UpdatedEmail='Cap_avenge@yahoo.com';
        $this->patch("/api/user/{$user->id}/profile",['name'=>$Updatedname,'email'=>$UpdatedEmail]);
        $this->assertDatabaseHas('users',['id'=>$user->id,'name'=>$Updatedname]);
    }

    /** @test */
      public function profile_owner_can_delete_project(){
        $user=create('App\User');
         $this->signIn($user);
         $project=create('App\Project',['user_id'=>$user->id]);
         $this->withoutExceptionHandling()->delete('api/user/'.$user->id.'/profile');
         $this->assertDatabaseMissing('users',['id'=>$user->id]);
         $this->assertDatabaseMissing('projects',['id'=>$project->id]);
      }

              /** @test */
    public function group_deleted_on_user_deletion()
    {
      $user=create('App\User');
       $this->signIn($user);
        $group=create('App\Group');
     $group->users()->attach($user);
     $user->delete();
      $this->assertDatabaseMissing('groups',['id'=>$group->id]);
}
}
