<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Task;
use App\Models\User;
use App\Models\Project;

class ProjectTest extends TestCase
{
  use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */

  /** @test */
  public function a_project_can_make_a_string_path(){
      $project=Project::factory()->create();
      $this->assertEquals(
          "/api/v1/projects/{$project->slug}",$project->path());
  }

   /** @test */
   public function a_project_has_a_creator()
   {
     $project=Project::factory()->create();
     $this->assertInstanceOf('App\Models\User',$project->user);
   }

   /** @test */
   public function project_belongs_to_stage()
   {
     $project=Project::factory()->create();
     $this->assertInstanceOf('App\Models\Stage',$project->stage);
   }

   /** @test */
   public function mark_uncomplete_if_completed()
   {
     $project=Project::factory()->create(['completed'=>true]);
     $project->markUncompleteIfCompleted();
     $this->assertFalse($project->completed);
   }

   /** @test */
   public function remove_postponed_reason_if_exists()
   {
     $project=Project::factory()->create(['postponed'=>'Unable to junk']);
     $project->removePostponedIfExists();
     $this->assertEquals(null,$project->postponed);
   }

  /** @test */
   public function a_project_can_add_a_task()
   {
     $project=Project::factory()->create();
     $project->addTask('run berry run');
     $this->assertCount(1,$project->tasks);
  }

   /** @test */
   public function a_project_has_tasks()
  {
    $project=Project::factory()->create();
    $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $project->tasks);
  }

  /** @test */
  public function invitation_can_be_sent_to_a_user()
  {
     $project = Project::factory()->create();
     $project->invite($user=User::factory()->create());
     $this->assertTrue($project->members->contains($user));
  }

  /** @test */
  public function get_project_score_and_status()
  {
    $project = Project::factory()->create();

    Task::factory()->for($project)->count(4)->create();

    $project->notes = "Some notes";

    $this->userBecomeMember($project);

    $this->assertEquals(14, $project->score());

    $this->assertEquals('cold', $project->status());
  }

  /** @test */
  /*public function check_project_status()
  {
     $project = Project::factory()
       ->hasScores(5,[
        'point'=>10
      ])
      ->create();
      $this->assertEquals($project->currentStatus(),'hot');
  }*/

     protected function userBecomeMember($project)
   {
     $project->members()->attach($user=User::factory()->create());

     \DB::table('project_members')
     ->where('project_id', $project->id)
     ->where('user_id', $user->id)
     ->update(['active' =>true]);
   }

}
