<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
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
    
    
    /** @test */
    public function a_valid_avatar_must_be_provided(){
      $user=User::first();

       $this->postJson(route('user.avatar', ['user' => $user->id]),['avatar' => 'not-an-image'])->assertUnprocessable();
    }

    /** @test */
    public function authorize_user_may_add_avatar_to_project()
    {
      $user=User::first();

        Storage::fake('s3');

        $file=UploadedFile::fake()->image('avatar.jpg');

        $response=$this->withoutExceptionHandling()->postJson('api/v1/users/'.$user->id.'/avatar',[
            'avatar'=>$file,
        ])->assertSuccessful();

        $uploadedFile='avatars/'.$user->id.'_'.$file->hashName();

        Storage::disk('s3')->assertExists($uploadedFile);
    }

    /*public function a_user_can_determine_their_avatar_path()
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
