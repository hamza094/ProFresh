<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
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

         Sanctum::actingAs(
            User::first(),
         );
     }

   /** @test */
    public function auth_user_see_all_users()
    {
        $user = User::factory()->create();
        $this->getJson('/api/v1/users')->assertSee($user->name);
    }
}
