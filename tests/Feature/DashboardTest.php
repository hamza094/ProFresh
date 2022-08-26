<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Project;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\Hash;

class DashboardTest extends TestCase
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
    public function user_can_view_his_projects_on_dashboard()
    {
        $projects=Project::factory()->count(4)->for(User::first())->create();

        $response=$this->withoutExceptionHandling()->getJson('/api/v1/user/projects');

        $response
        ->assertStatus(200)
        ->assertJson([
            'projects'=>[0=>['name'=>$projects[0]->name]],
           ]);

        $project=Project::first();

        $this->deleteJson($project->path());

        $response=$this->getJson('/api/v1/user/projects?abandoned=true')->assertSee($project->name)
        ->assertStatus(200);

        $response->assertJson([
            'projects'=>[0=>['name'=>$project->name]],
            'projectsCount'=>1
          ]);
    }

}
