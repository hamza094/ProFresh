<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

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
    $this->signIn();
      $project=create('App\Project');
      $this->assertEquals(
          "/api/projects/{$project->id}",$project->path());
  }


/** @test */
  public function a_project_has_a_creator()
  {
    $this->signIn();
      $project=create('App\Project');
      $this->assertInstanceOf('App\User',$project->user);
  }


  public function it_belongs_to_a_Account()
  {
    $this->signIn();
      $project = create('App\Project');
      $this->assertInstanceOf('App\Account', $project->account);
  }

  /** @test */
  public function a_project_can_add_a_task()
  {
      $this->signIn();
      $project=create('App\Project');
      $project->addTask('run berry run');
      $this->assertCount(1,$project->tasks);
  }

  /** @test */
  public function an_project_can_be_followed_to(){
    $this->signIn();
      $project=create('App\Project');
      $project->subscribe($userId=1);
      $this->assertEquals(1,$project->subscribers()->where('user_id',$userId)->count());
  }

  /** @test */
public function an_event_can_be_unfollowed_from()
{
  $this->signIn();
   $project = create('App\Project');
   $project->subscribe($userId = 1);
   $project->unsubscribe($userId);
   $this->assertCount(0, $project->subscribers);
}

/** @test */
  public function it_can_invites_a_user(){
    $this->signIn();
      $project = create('App\Project');
      $project->invite($user=create('App\User'));
      $this->assertTrue($project->members->contains($user));
  }

}
