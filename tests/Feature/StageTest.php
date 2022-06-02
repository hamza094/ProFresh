<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Project;
use App\Models\Stage;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;

class StageTest extends TestCase
{
  use RefreshDatabase;

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

      Stage::factory()->create();
      Stage::factory()->define()->create();
      Stage::factory()->design()->create();
  }

  /** @test */
  public function auth_user_can_change_project_stage()
  {
     $project=Project::factory()->create(['stage_id'=>1]);
     $this->assertEquals('Begining',$project->stage->name);
     $response=$this->patchJson($project->path().'/stage',[
          'stage'=>2,
      ]);
      $this->assertDatabaseHas('projects',['id'=>$project->id,'stage_id'=>2]);
      $project->refresh();

      $response->assertJson([
        'msg'=>'Project '.$project->slug.' Stage Updated Successfully',
        'project'=>[
          'stage'=>['name'=>$project->stage->name,'id'=>$project->stage->id],
          'stage_updated_at'=>$project->stage_updated_at->format("F j, Y, g:i a")]
       ]);
 }

  /** @test */
  public function auth_user_can_postponed_stage_and_update_reason()
  {
    $project=Project::factory()->create(['stage_id'=>1]);

    $response=$this->withoutExceptionHandling()->patchJson($project->path().'/stage',[
      'postponed'=>'Unable to reach'
  ]);

  $this->assertDatabaseHas('projects',['id'=>$project->id,'postponed'=>'Unable to reach','stage_id'=>null]);
  $project->refresh();
  $response->assertJson([
       'project'=>['postponed'=>$project->postponed]
   ]);
  }

  /** @test */
  public function auth_user_can_update_stage_to_complete()
  {
    $project=Project::factory()->create(['stage_id'=>1]);
    $response=$this->patchJson($project->path().'/stage',[
      'completed'=>'true',
  ]);
     $this->assertDatabaseHas('projects',['id'=>$project->id,'completed'=>true,'stage_id'=>null]);
     $project->refresh();
     $response->assertJson([
          'project'=>['completed'=>$project->completed]
      ]);
   }
}
