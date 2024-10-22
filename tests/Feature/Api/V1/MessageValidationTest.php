<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Traits\ProjectSetup;
use App\Models\User;
use Tests\TestCase;

class MessageValidationTest extends TestCase
{
  use RefreshDatabase,ProjectSetup;


   /** @test */
   public function validate_message_errors()
   {
     $users=[];

     $users=json_encode(User::factory(2)->create());

     $this->postJson($this->project->path().'/message',['message'=>null,'users'=>$users])
     ->assertUnprocessable()
     ->assertJsonMissingValidationErrors('data.message');
   }

   /** @test */
   public function check_message_option_select()
   {
     $users=[];
     $users=json_encode(User::factory(2)->create());

     $this->postJson($this->project->path().'/message',
     ['message'=>'this is my post','users'=>$users,'mail'=>null,'sms'=>null])
     ->assertUnprocessable()
     ->assertJsonValidationErrors('option');
   }

}
