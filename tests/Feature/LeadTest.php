<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LeadTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    /** @test */
    public function auth_user_can_create_lead()
    {
        $this->signIn();
        $lead=make('App\Lead');
        $response=$this->post('api/leads',
            ['name' => 'Json','email'=>'json_pisces@outlook.com','owner'=>'admin']);
          $this->assertDatabaseHas('leads',['name'=>'Json']);

    }
}
