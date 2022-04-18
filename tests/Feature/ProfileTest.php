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

     public function sign_user_see_his_profile(){
       $this->signIn();
       $user=create('App\Models\User');
       $this->withoutExceptionHandling()->get('/api/profile/user/'.$user->id)->assertSee($user->name);
     }

    public function avatar_can_be_added_by_profile_owner()
    {

        $this->json('POST','api/user/1/avatar')
            ->assertStatus(401);
    }

    public function a_valid_avatar_must_be_provided(){
      $user=create('App\Models\User');
       $this->signIn($user);
        $this->json('POST','api/user/'.$user->id.'/avatar',[
            'avatar'=>'not-an-image'
        ])->assertStatus(422);
    }

    public function authorize_user_may_add_avatar_to_project()
    {
      $user=create('App\Models\User');
       $this->signIn($user);
        Storage::fake('s3');
        $this->json('POST','api/user/'.$user->id.'/avatar',[
            'avatar_path'=>$file=UploadedFile::fake()->image('avatar.jpg')
        ]);

        Storage::disk('s3')->assertExists('avatars/'.$file->hashName());
    }

    public function a_user_can_determine_their_avatar_path()
    {
      $user=create('App\Models\User');
       $this->signIn($user);
        $user->avatar_path='http://localhost/storage/avatars/me.jpg';
        $this->assertEquals(asset('storage/avatars/me.jpg'),$user->avatar_path);
    }


         public function profile_owner_can_delete_his_avatar(){
           $user=create('App\Models\User',['avatar_path'=>'https://encrypted-tbn0.gstatic.com']);
            $this->signIn($user);
            $this->patch('api/user/'.$user->id.'/avatar-delete');
            $this->assertDatabaseHas('users',['avatar_path'=>null]);
         }


        public function profile_owner_can_update_his_profile(){
        $user=create('App\Models\User');
        $this->signIn($user);
        $Updatedname='Assemble';
        $UpdatedEmail='Cap_avenge@yahoo.com';
        $this->patch("/api/profile/user/{$user->id}",['name'=>$Updatedname,'email'=>$UpdatedEmail]);
        $this->assertDatabaseHas('users',['id'=>$user->id,'name'=>$Updatedname]);
    }

      public function profile_owner_can_delete_project(){
        $user=create('App\Models\User');
         $this->signIn($user);
         $project=create('App\Models\Project',['user_id'=>$user->id]);
         $this->delete('api/profile/user/'.$user->id);
         $this->assertDatabaseMissing('users',['id'=>$user->id]);
         $this->assertDatabaseMissing('projects',['id'=>$project->id]);
      }

    public function group_deleted_on_user_deletion()
    {
      $user=create('App\Models\User');
       $this->signIn($user);
        $group=create('App\Models\Group');
     $group->users()->attach($user);
     $user->delete();
      $this->assertDatabaseMissing('groups',['id'=>$group->id]);
}
}
