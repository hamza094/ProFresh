<?php

namespace Tests\Feature\Api\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialiteUser;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Mockery as m;
use Faker\Factory as Faker;
use App\Enums\OAuthProvider;
use Illuminate\Support\Facades\Crypt;
use Tests\TestCase;

class OAuthTest extends TestCase
{ 
    use RefreshDatabase;

    /** @test */
    public function test_OAuth_redirect()
    {
        $provider = OAuthProvider::GitHub;

        $response = $this->getJson('/api/v1/auth/redirect/'.$provider->value);        

        $response->assertStatus(200)
                 ->assertJsonStructure(['redirect_url']);
    }

    /** @test */
    public function give_old_user_if_its_present()
    {
        $user=User::factory(['email' => 'test@example.com'])->create();

        $this->performOAuthCallback();

        $response=$this->get(route('oauth.callback', ['provider' => 'github']))->assertSuccessful();
        
        $this->assertDatabaseHas('users', [
            'name' => $user->name,
            'username' => $user->username,
            'avatar_path' => $user->avatar_path,
            'oauth_id' => '123',
            'oauth_provider' => OAuthProvider::GitHub,
        ]);

        $user = User::where('email', 'test@example.com')->first();

        $this->assertEquals('access-token', $user->oauth_token);
        $this->assertEquals('refresh-token', $user->oauth_refresh_token);
    }


    /** @test */
    public function test_OAuth_callback()
    {
        $this->performOAuthCallback();

        $response=$this->get(route('oauth.callback', ['provider' => 'github']))->assertSuccessful()
                        ->assertJsonStructure([
                         'user' => ['uuid','name','email'],
                         'access_token',
                         'message'
                        ]);
        
        $this->assertDatabaseHas('users', [
            'name' => 'Test User',
            'username' => 'jinx004',
            'avatar_path' => 'https://example.com/avatar.jpg',
            'oauth_id' => '123',
            'oauth_provider' => OAuthProvider::GitHub,
        ]);

        $user = User::where('email', 'test@example.com')->first();

        $this->assertEquals('access-token', $user->oauth_token);
        $this->assertEquals('refresh-token', $user->oauth_refresh_token);
    }

    /**
      * Perform the OAuth callback for testing.
    */
    private function performOAuthCallback()
    {
      $this->mockSocialite('github', [
         'id' => '123',
         'name' => 'Test User',
         'email' => 'test@example.com',
         'token' => 'access-token',
         'nickname' => 'jinx004',
         'avatar' => 'https://example.com/avatar.jpg',
         'refreshToken' => 'refresh-token',
      ]); 
    }

    protected function mockSocialite($provider, $user = null)
    {
        $mock = Socialite::shouldReceive('stateless')
            ->andReturn(m::self())
            ->shouldReceive('driver')
            ->with($provider)
            ->andReturn(m::self());

        if ($user) {
            $mock->shouldReceive('user')
                ->andReturn((new SocialiteUser)->setRaw($user)->map($user));
        } else {
            $mock->shouldReceive('redirect')
                ->andReturn(redirect('https://url-to-provider'));
        }
    }

}
