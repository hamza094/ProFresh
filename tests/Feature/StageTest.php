<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use App\Models\User;
use App\Models\Project;
use App\Models\Stage;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;

class StageTest extends TestCase
{
  use RefreshDatabase;

  public $project;

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

      $this->project=Project::factory()->for($user)
      ->create(['stage_id'=>1]);
  }

  /** @test */
  public function allowed_user_can_change_project_stage()
  {
    $this->assertEquals('Begining',$this->project->stage->name);

    $response=$this->patchJson($this->project->path().'/stage',[
          'stage'=>2,
      ]);

      $this->assertDatabaseHas('projects',['id'=>$this->project->id,'stage_id'=>2]);

      $this->project->refresh();

      $response->assertJson([
        'project'=>[
          'stage'=>['name'=>$this->project->stage->name,
                   'id'=>$this->project->stage->id],
          'stage_updated_at'=>$this->project->stage_updated_at
                              ->format("F j, Y, g:i a")]
       ]);
 }

  /** @test */
  public function allowed_user_can_postponed_stage_and_update_reason()
  {
    $response=$this->patchJson($this->project->path().'/stage',[
      'postponed'=>'Unable to reach'
      ]);

    $this->assertDatabaseHas('projects',['id'=>$this->project->id,'postponed'=>'Unable to reach','stage_id'=>null]);

     $this->project->refresh();

     $response->assertJson([
       'project'=>['postponed'=>$this->project->postponed]
   ]);

  }

  /** @test */
  public function allowed_user_can_update_stage_to_complete()
  {
     $response=$this->patchJson($this->project->path().'/stage',[
      'completed'=>'true',
     ]);

     $this->assertDatabaseHas('projects',['id'=>$this->project->id,'completed'=>true,'stage_id'=>null]);

     $this->project->refresh();

     $response->assertJson([
          'project'=>['completed'=>$this->project->completed]
      ]);
   }
}
