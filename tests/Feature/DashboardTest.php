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
    public function user_can_view_his_projects_on_dashboard(){
        $user=User::first();
        $projects=Project::factory()->count(4)->for($user)->create();
        $this->withoutExceptionHandling()->getJson('/api/v1/userprojects')->assertSee($projects[0]->name)
        ->assertStatus(200);
        $project=Project::first();
        $this->deleteJson($project->path());
        $response=$this->getJson('/api/v1/userprojects?abandoned=true')->assertSee($project->name)
        ->assertStatus(200);
        $this->assertEquals(1,$response->json(['projectsCount']));
    }

   public function project_owner_can_trash_project(){
     $user=create('App\Models\User');
      $this->signIn($user);
      $project=create('App\Models\Project',['user_id'=>$user->id]);
      $this->assertCount(1,$project->get());
      $this->delete($project->path());
      $this->assertCount(0,$project->get());
$this->assertCount(1,$project->withTrashed()->get());
   }






}
