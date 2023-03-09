<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use App\Models\User;
use Tests\TestCase;

class UserAvatarTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() :void
    {
        parent::setUp();
         // create a user
        $user=User::factory()->create([
             'email'=>'johndoe@example.org',
             'password'=>Hash::make('testpassword'),
             'name'=>'jon doe',
         ]);

         Sanctum::actingAs(
             $user,
         ); 
    }
    
    /*public function avatar_can_be_added_by_profile_owner()
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
    }*/

    /** @test */
    public function profile_owner_can_delete_his_avatar()
    {
      $user=User::first();
      
      $this->patchJson('api/v1/users/'.$user->id.'/avatar_remove');

      $this->assertDatabaseHas('users',['avatar_path'=>null]);

      $response=$this->patchJson('api/v1/users/'.$user->id.'/avatar_remove')->assertStatus(400);
    }

}
