<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Task;
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


  public function a_project_can_add_a_task()
  {
      $this->signIn();
      $project=create('App\Models\Project');
      $project->addTask('run berry run');
      $this->assertCount(1,$project->tasks);
  }


 public function a_project_has_tasks()
{
  $this->signIn();
    $project=create('App\Models\Project');
    $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $project->tasks);
}


public function a_project_has_appointments()
{
$this->signIn();
  $project=create('App\Models\Project');
  $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $project->appointments);
}


  public function an_project_can_be_followed_to(){
    $this->signIn();
      $project=create('App\Models\Project');
      $project->subscribe($userId=1);
      $this->assertEquals(1,$project->subscribers()->where('user_id',$userId)->count());
  }


public function an_event_can_be_unfollowed_from()
{
  $this->signIn();
   $project = create('App\Models\Project');
   $project->subscribe($userId = 1);
   $project->unsubscribe($userId);
   $this->assertCount(0, $project->subscribers);
}


  public function it_can_invites_a_user(){
    $this->signIn();
      $project = create('App\Models\Project');
      $project->invite($user=create('App\Models\User'));
      $this->assertTrue($project->members->contains($user));
  }

}
