<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use App\Mail\PasswordUpdate;
use Illuminate\Support\Facades\Mail;
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
      $response=$this->getJson('/api/v1/users');

        $response->assertStatus(200)
                 ->assertJsonFragment([
                  'id'=>$this->user->id,
                  'name'=>$this->user->name
               ]);
      
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

    /** @test */
    public function user_can_delete_his_profile()
    {
      $this->deleteJson('api/v1/users/'.$this->user->id);

      $this->assertModelMissing($this->user);

      $this->assertModelMissing($this->project);
    }

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
