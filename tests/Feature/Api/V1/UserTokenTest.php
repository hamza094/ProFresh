<?php

namespace Tests\Feature\Api\V1;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UserTokenTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
         parent::setUp();
         // create a user
        $user = User::factory()->create([
             'email'=>'johndoe@example.org',
             'password'=>Hash::make('testpassword'),
             'name'=>'jon doe',
         ]);
    }

    /** @test */
    public function user_can_list_their_tokens()
    {
        $user = User::first();

                Sanctum::actingAs(
        $user,
        ['*'],
    );

        $token = $user->createToken('Test Token', ['*']);
        $response = $this->getJson('/api/v1/api-tokens');
        $response->assertOk();
        $response->assertJsonFragment(['name' => 'Test Token']);
    }

    /** @test */
    public function user_can_create_a_token()
    {
        $user = User::first();

                Sanctum::actingAs(
        $user,
        ['*'],
    );

        $response = $this->postJson('/api/v1/api-tokens', [
            'name' => 'My API Token',
        ]);
        $response->assertCreated();
        $response->assertJsonFragment(['message' => 'Token created successfully.']);
        $this->assertDatabaseHas('personal_access_tokens', [
            'name' => 'My API Token',
            'tokenable_id' => $user->id,
        ]);
    }

    /** @test */
    public function user_can_delete_a_token()
    {
        $user = User::first();

        Sanctum::actingAs(
        $user,
    );

        $token = $user->createToken('Delete Token', ['*']);
        $tokenId = $token->accessToken->id;
        $response = $this->deleteJson('/api/v1/api-tokens/' . $tokenId);
        $response->assertOk();
        $response->assertJsonFragment(['message' => 'Token deleted.']);
        $this->assertDatabaseMissing('personal_access_tokens', [
            'id' => $tokenId,
        ]);
    }
    

    /** @test */
    public function user_cannot_delete_current_session_token_via_route()
    {
        $user = User::first();
        $tokenResult = $user->createToken('Session Token', ['*']);
        $plainText   = $tokenResult->plainTextToken;
        $tokenModel  = $tokenResult->accessToken;

        $response = $this
            ->withToken($plainText)
            ->deleteJson("/api/v1/api-tokens/{$tokenModel->id}");

        $response->assertStatus(403)
                 ->assertJsonFragment([
                   'message' => 'Cannot delete the current session token via this route.'
                 ]);
    }
}
