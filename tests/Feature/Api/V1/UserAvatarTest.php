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

    /** @test */
    public function profile_owner_can_delete_his_avatar()
    {
        Storage::fake('s3');

       $user=User::first();

       $file=UploadedFile::fake()->image('avatar.jpg');

        $user->update([
          'avatar_path' => $file
        ]);

        $response=$this->patchJson('api/v1/users/'.$user->id.'/avatar_remove');

        $response
        ->assertJson([
            'message' => 'User avatar has been removed',
        ])->assertStatus(200);

        $this->assertNull($user->fresh()->avatar_path);

        Storage::disk('s3')->assertMissing($file);

        $response=$this->patchJson('api/v1/users/'.$user->id.'/avatar_remove');

        $response
        ->assertJson([
            'error' => 'User does not have an avatar',
        ])->assertStatus(400);
    }

}
