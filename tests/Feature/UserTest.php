<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Mail\PasswordUpdate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\UploadedFile;
use App\Services\UserService;
use App\Traits\ProjectSetup;
use Laravel\Sanctum\Sanctum;
use App\Models\Project;
use App\Models\User;
use App\Models\UserInfo;
use Tests\TestCase;
use Carbon\Carbon;

class UserTest extends TestCase
{
  use RefreshDatabase,ProjectSetup;

    /**
     *
     * @return void
     */

   /** @test */
    public function auth_user_see_all_users()
    {
      $this->getJson('/api/v1/users')
            ->assertSee($this->user->name);
    }

     /** @test */
    public function auth_user_can_get_his_data()
    {
      $response=$this->getJson($this->user->path())
                     ->assertSee($this->user->name);
    }

    /** 
    * @test 
    * @dataProvider dataProvider 
    */
    public function owner_can_update_his_data($newName,$newUsername, $newEmail, $newCompany, $newMobile)
    {
      UserInfo::factory()->for($this->user)->create();

      $this->patchJson($this->user->path(), [
        'name' => $newName,
        'email' => $newEmail,
        'username' => $newUsername,
        'company' => $newCompany,
        'mobile' => $newMobile,
    ]);

      $this->assertDatabaseHas('users', [
        'id' => $this->user->id,
        'name' => $newName,
        'email' => $newEmail,
    ])
      ->assertDatabaseHas('user_infos', [
        'user_id' => $this->user->id,
        'company' => $newCompany,
        'mobile' => $newMobile,
     ]);
  }

    /** @test */
    public function it_can_update_user_password()
    {
      Mail::fake();

      $user=$this->user;
      $newPassword = 'new_password';

      $userService = new UserService();

      $userService->updatePassword($user, $newPassword);

      $this->assertTrue(Hash::check($newPassword, $user->password));

        Mail::assertQueued(PasswordUpdate::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });
    }
 
    /** @test */
    public function password_update_mail_contains_time()
    {
      $time=Carbon::now()->toDayDateTimeString();
 
      $mailable = new PasswordUpdate($time);
 
      $mailable->assertSeeInHtml($time);
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
    }


         public function profile_owner_can_delete_his_avatar(){
           $user=create('App\Models\User',['avatar_path'=>'https://encrypted-tbn0.gstatic.com']);
            $this->signIn($user);
            $this->patch('api/user/'.$user->id.'/avatar-delete');
            $this->assertDatabaseHas('users',['avatar_path'=>null]);
         }

      public function profile_owner_can_delete_project(){
        $user=create('App\Models\User');
         $this->signIn($user);
         $project=create('App\Models\Project',['user_id'=>$user->id]);
         $this->delete('api/profile/user/'.$user->id);
         $this->assertDatabaseMissing('users',['id'=>$user->id]);
         $this->assertDatabaseMissing('projects',['id'=>$project->id]);
      }*/


  public function dataProvider(): array
  {
    return [
    [
      'newName' => 'john doe',
      'newUsername' => 'jane_doe',
      'newEmail' => 'john_doe@example.com',
      'newCompany' => 'Acme Inc.',
      'newMobile' => 1234567890,
      ],
    ];
  }
}
