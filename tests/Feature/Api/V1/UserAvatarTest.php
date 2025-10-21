<?php

namespace Tests\Feature\Api\V1;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UserAvatarTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // create a user
        $user = User::factory()->create([
            'email' => 'johndoe@example.org',
            'password' => Hash::make('testpassword'),
            'name' => 'jon doe',
        ]);

        Sanctum::actingAs(
            $user,
        );
    }

    /** @test */
    public function a_valid_avatar_must_be_provided()
    {
        $user = User::first();

        $this->postJson(route('user.avatar', ['user' => $user->uuid]), ['avatar' => 'not-an-image'])->assertUnprocessable();
    }

    /** @test */
    public function authorize_user_may_add_avatar_to_his_profile()
    {
        $user = User::first();

        Storage::fake('s3');

        $file = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->withoutExceptionHandling()->postJson('api/v1/users/'.$user->uuid.'/avatar', [
            'avatar' => $file,
        ])->assertSuccessful();

        $uploadedFile = 'avatars/'.$user->uuid.'_'.$file->hashName();

        Storage::disk('s3')->assertExists($uploadedFile);
    }

    /** @test */
    public function profile_owner_can_delete_his_avatar()
    {
        Storage::fake('s3');

        $user = User::first();

        $file = UploadedFile::fake()->image('avatar.jpg');

        $user->update([
            'avatar_path' => $file,
        ]);

        $response = $this->patchJson('api/v1/users/'.$user->uuid.'/avatar_remove');

        $response
            ->assertJson([
                'message' => 'User avatar has been removed',
            ])->assertStatus(200);

        $this->assertNull($user->fresh()->avatar_path);

        Storage::disk('s3')->assertMissing($file);

        $response = $this->patchJson('api/v1/users/'.$user->uuid.'/avatar_remove');

        $response
            ->assertJson([
                'message' => 'User does not have an avatar',
            ])->assertStatus(404);
    }
}
