<?php

namespace Tests\Feature\Api\V1;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use App\Mail\PasswordUpdate;
use Illuminate\Support\Facades\Mail;
use App\Services\Api\V1\UserService;
use Spatie\Permission\Models\Role;
use App\Traits\ProjectSetup;
use Laravel\Sanctum\Sanctum;
use App\Actions\DeleteProfileAction;
use App\Models\Project;
use App\Models\User;
use App\Models\UserInfo;
use Tests\TestCase;
use Carbon\Carbon;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\DataProvider;

class UserTest extends TestCase
{

  use RefreshDatabase,ProjectSetup;

    /**
     *
     * @return void
     */

  #[Test]
    public function auth_user_see_all_users()
    {
      $response=$this->getJson('/api/v1/users');

        $response->assertStatus(200)
                 ->assertJsonFragment([
                  'name'=>$this->user->name,
                  'email'=>$this->user->email
               ]);
      
    }

  #[Test]
    public function auth_user_can_get_his_data()
    {
        $response = $this->getJson($this->user->path());

        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'id' => $this->user->id,
                     'name' => $this->user->name,
                     'email' => $this->user->email,
                 ]);
    }

  #[Test]
  #[DataProvider('dataProvider')]
    public function owner_can_update_his_data($newName, $newUsername, $newEmail, $newCompany, $newMobile)
    {
        UserInfo::factory()->for($this->user)->create();

        $response = $this->patchJson($this->user->path(), [
            'name' => $newName,
            'email' => $newEmail,
            'username' => $newUsername,
            'company' => $newCompany,
            'mobile' => $newMobile,
        ]);

        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'name' => $newName,
                     'email' => $newEmail,
                     'username' => $newUsername,
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

  #[Test]
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
 
  #[Test]
    public function password_update_mail_contains_time()
    {
      $time=Carbon::now()->toDayDateTimeString();
 
      $mailable = new PasswordUpdate($time);
 
      $mailable->assertSeeInHtml($time);
    }


  #[Test]
  public function user_can_delete_his_profile()
  {
    $this->deleteJson('api/v1/users/'.$this->user->uuid);

    $this->assertSoftDeleted($this->user);

    // If projects are soft deleted on user delete:
    $this->assertSoftDeleted($this->project);
  }

  #[Test]
    public function it_permanently_deletes_user_and_handles_projects_after_15_days()
    {
        Role::findOrCreate('Admin', 'sanctum');

        // Create a user and soft delete them 16 days ago
        $user = User::factory()->create(['deleted_at' => now()->subDays(16)]);
        $admin = User::factory()->create();
        $admin->assignRole('Admin');

        $projectNoMembers = Project::factory()->create(['user_id' => $user->id]);
      
        $projectWithMembers = Project::factory()->create(['user_id' => $user->id]);
        $projectWithMembers->members()->attach($admin->id);

        (new DeleteProfileAction())->execute();

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
        
        $this->assertDatabaseMissing('projects', ['id' => $projectNoMembers->id]);
  
        $projectWithMembersFresh = Project::withTrashed()->find($projectWithMembers->id);
        $this->assertNotNull($projectWithMembersFresh);
        $this->assertSoftDeleted('projects', ['id' => $projectWithMembers->id]);
        $this->assertEquals($admin->id, $projectWithMembersFresh->user_id);
    }


  #[Test]
    public function test_user_profile_delete_command_runs()
    {
      $this->artisan('user:profile-delete')
        ->expectsOutput('User profile deletion process completed.')
        ->assertExitCode(0);
    }

  public static function dataProvider(): array
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
