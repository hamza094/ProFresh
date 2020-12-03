<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\Project;


class SubscriptionTest extends TestCase
{
  use RefreshDatabase;

  /** @test */
  public function a_signIn_user_subscribe_to_project()
  {
      $this->signIn();
      $project=create("App\Project");
      $this->post($project->path().'/subscribe');
      $this->assertCount(1, $project->subscribers);
  }

  /** @test */
  public function a_signIn_user_unsubscribe_to_project()
  {
      $this->signIn();
      $project=create("App\Project");
      $this->delete($project->path().'/unsubscribe');
      $this->assertCount(0, $project->subscribers);
  }

}
