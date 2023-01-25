<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use App\Models\User;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() :void
    {
        parent::setUp();

        // create a user
        User::factory()->create([
            'email'=>'johndoe@example.org',
            'password'=>Hash::make('testpassword')
        ]);

    }

    /** @test */
    public function register_new_user()
    {
       $response=$this->postJson(route('auth.register'),
            ['name' => 'Elvis William',
            'email'=>'mihupocob@mailinator.com',
             'password' => 'password',
             'password_confirmation' =>  'password',
         ])->assertCreated();

          $this->assertDatabaseHas('users',['email'=>'mihupocob@mailinator.com']);
    }

    /** @test */
    public function return_user_and_access_token_after_successful_login()
    {
        $response = $this->postJson(route('auth.login'), [
            'email' =>'johndoe@example.org',
            'password' => 'testpassword',
        ]);

        $response->assertOk()
            ->assertJsonStructure(['user', 'access_token']);
    }

    /** @test */
    public function show_validation_email_error()
    {
        $response = $this->postJson(route('auth.login'), [
            'email' => 'test@test.com',
            'password' => 'testpassword'
        ]);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['email']);
    }

    /** @test */
    public function authenticated_user_can_logout()
    {
        Sanctum::actingAs(
            User::first(),
        );

        $response = $this->postJson(route('auth.logout'), []);
        $response->assertOk();
    }

    /** @test */
   public function registration_with_existing_email_not_allowed()
   {
      $response=$this->postJson(route('auth.register'),
           ['name' => 'Elvis William',
           'email'=>'johndoe@example.org',
            'password' => 'password',
            'password_confirmation' =>  'password',
        ])->assertUnprocessable()
        ->assertJsonValidationErrors(['email']);
   }
}
