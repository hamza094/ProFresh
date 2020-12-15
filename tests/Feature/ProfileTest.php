<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProfileTest extends TestCase
{
  use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

     /** @test */
     public function sign_user_see_his_profile(){
       $this->signIn();
       $user=create('App\User');
       $this->withoutExceptionHandling()->get('users/'.$user->id.'/profile')->assertSee($user->name);
     }
}
