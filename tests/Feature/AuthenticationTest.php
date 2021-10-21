<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use App\Models\User;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

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
        $password = Hash::make('password');
        
        $response=$this->json('POST', route('auth.register'),
            ['name' => 'Elvis William',
            'email'=>'mihupocob@mailinator.com',
             'password' => $password,
             'password_confirmation' =>  $password,
         ])->assertCreated();

          $this->assertDatabaseHas('users',['email'=>'mihupocob@mailinator.com']);
    }
    
    /** @test */
    public function return_user_and_access_token_after_successful_login()
    {
        $response = $this->json('POST', route('auth.login'), [
            'email' =>'johndoe@example.org',
            'password' => 'testpassword',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['user', 'access_token']);
    }

    /** @test */
    public function show_validation_email_error()
    {
        $response = $this->json('POST', route('auth.login'), [
            'email' => 'test@test.com',
            'password' => 'testpassword'
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }
    
    /** @test */ 
    public function test_authenticated_user_can_logout()
    {
        Sanctum::actingAs(
            User::first(),
        );

        $response = $this->json('POST', route('auth.logout'), []);

        $response->assertStatus(200);
    }


}
