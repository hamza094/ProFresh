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
    public function user_create_project_account()
    {
      $this->signIn();
        $project=create('App\Project');
        $response=$this->post('api/project/'.$project->id.'/account',
            ['title' => 'widjet','country'=>'turkey','address'=>'bill phase 2',
                'number'=>'6785434567','industry'=>'armor','business'=>'sales']);
          $this->assertDatabaseHas('accounts',['title'=>'widjet']);
    }
}
