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
            'password'=>Hash::make('Testpassword@3')
        ]);

    }

    /** @test */
    public function register_new_user()
    {
       $response=$this->postJson(route('auth.register'),
            ['name' => 'Elvis William',
            'email'=>'mihupocob@mailinator.com',
             'password' =>'Password4!',
             'password_confirmation' => 'Password4!',
         ])->assertCreated();

          $this->assertDatabaseHas('users',['email'=>'mihupocob@mailinator.com']);
    }

    /** @test */
    public function return_user_and_access_token_after_successful_login()
    {
        $response = $this->postJson(route('auth.login'), [
            'email' =>'johndoe@example.org',
            'password' => 'Testpassword@3',
        ]);

        $response->assertOk()
            ->assertJsonStructure(['user', 'access_token']);
    }

    /** @test */
    public function show_validation_email_error()
    {
        $response = $this->postJson(route('auth.login'), [
            'email' => 'test@test.com',
            'password' => 'Testpassword@3'
        ]);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['email']);
    }

      /** @test */
    public function show_validation_password_errors()
    {
       $response=$this->postJson(route('auth.register'),
            ['name' => 'Elvis William',
            'email'=>'mihupocob@mailinator.com',
             'password' =>'password',
             'password_confirmation' => 'password',
         ]);

        $response->assertUnprocessable()
        ->assertJsonValidationErrors(['password'])
        ->assertJson([
            'errors' => [
                'password' => [
                    "The password must include both uppercase and lowercase letters.",
                    "The password must include at least one special character (symbol).",
                    "The password must contain at least one number.",
                ]
            ]
        ]);
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
