<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Project;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use App\Models\Task;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApplicationTest extends TestCase
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
        $user=User::factory()->create([
             'email'=>'johndoe@example.org',
             'password'=>Hash::make('testpassword')
         ]);

         Sanctum::actingAs(
             $user,
         );

         Project::factory()->create(['user_id'=>$user->id]);
     }

     /** @test */
    public function only_allowed_users_access_different_application_features()
    {
       $project=Project::first();

         $this->postJson($project->path().'/task',
          ['body' => 'My Project Task'])->assertStatus(201);

          $project->invite($user=User::factory()->create());

          Sanctum::actingAs(
             $user,
         );

         $this->getJson($project->path().'/accept-invitation')->assertStatus(200);

         $this->postJson($project->path().'/task',
          ['body' => 'My Project Task Updated'])->assertStatus(201);

          Sanctum::actingAs(
             User::factory()->create(),
         );

         $response=$this->postJson($project->path().'/task',
          ['body' => 'My Project Task Updated'])->assertStatus(403);

          $response->assertJson([
              'message'=>"Only Project's owner and members are allowed to access this feature.",
            ]);
    }
}
