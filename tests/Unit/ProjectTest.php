<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Enums\ScoreValue;
use App\Actions\ScoreAction;
use App\Models\Task;
use App\Models\User;
use App\Models\TaskStatus;
use App\Models\Project;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\Hash;

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
      $user=User::factory()->create();
      Sanctum::actingAs($user);
      $status=TaskStatus::factory()->create();
     $project=Project::factory()->create(['user_id'=>$user->id]);
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
  public function get_project_total_score()
  {
    $status=TaskStatus::factory()->create();
    $project = Project::factory()->create();

    Task::factory()->for($project)->count(4)->create();

    $project->notes = "Some notes";

    $user=User::factory()->create();

    $this->addMember($project,$user);

    $expectedScore = (4 * ScoreValue::Task) + ScoreValue::Note + (1 * ScoreValue::Members);

    $this->assertEquals($expectedScore, $project->score());
  }

  /** @test */
  public function check_project_status()
  {
    $status=TaskStatus::factory()->create();
    $project = Project::factory()->create();

    Task::factory()->for($project)->count(4)->create();

    $this->assertEquals($project->status,'cold');

    Task::factory()->for($project)->count(7)->create();

    $this->assertEquals(22, $project->score());

    $this->assertEquals($project->status,'hot');
  }

    protected function addMember($project,$user)
    {
      $project
      ->members()
      ->attach($user, ['active' => true]);
   }

}
