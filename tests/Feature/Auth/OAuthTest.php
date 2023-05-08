<?php

namespace Tests\Feature\Auth;

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
    public function test_OAuth_callback()
    {
        $this->mockSocialite('github', [
            'id' => '123',
            'name' => 'Test User',
            'email' => 'test@example.com',
            'token' => 'access-token',
            'refreshToken' => 'refresh-token',
        ]);

        $response=$this->withoutExceptionHandling()->
                         getJson('/api/v1/auth/callback/github')
                        ->assertSuccessful()
                        ->assertJsonStructure([
                         'user' => ['id','name','email'],
                         'access_token'
                        ]);
        
        $this->assertDatabaseHas('users', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'oauth_id' => '123',
            'oauth_provider' => OAuthProvider::GitHub,
        ]);

        $user = User::where('email', 'test@example.com')->first();

         $this->assertEquals('access-token', $user->oauth_token);
        $this->assertEquals('refresh-token', $user->oauth_refresh_token);
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
