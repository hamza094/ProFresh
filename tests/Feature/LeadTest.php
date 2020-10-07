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
        $response=$this->post('api/leads',
            ['name' => 'Json','email'=>'json_pisces@outlook.com','owner'=>'admin']);
          $this->assertDatabaseHas('leads',['name'=>'Json']);

    }

    /** @test */
    public function a_lead_requires_a_name(){
        $this->signIn();
        $lead=make('App\Lead',[
            'name'=>null
        ]);
        $this->post('/api/leads',$lead->toArray())
            ->assertSessionHasErrors('name');

    }

    /** @test */
    public function auth_user_visit_lead(){
        $this->signIn();
        $lead=create('App\Lead');
        $this->get($lead->path())->assertSee($lead->id);
    }

}
