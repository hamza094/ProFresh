<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AccountTest extends TestCase
{
  use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

     /** @test */
    public function user_create_lead_account()
    {
      $this->signIn();
        $lead=create('App\Lead');
        $response=$this->withoutExceptionHandling()->post('api/lead/'.$lead->id.'/account',
            ['title' => 'widjet','country'=>'turkey','address'=>'bill phase 2',
                'number'=>'6785434567','industry'=>'armor','business'=>'sales']);
          $this->assertDatabaseHas('accounts',['title'=>'widjet']);
    }
}
