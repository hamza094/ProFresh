<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Project;


class SubscribeTest extends TestCase
{
  use RefreshDatabase;

  public function a_signIn_user_subscribe_to_project()
  {
      $this->signIn();
      $project=create("App\Models\Project");
      $this->post($project->path().'/subscribe');
      $this->assertCount(1, $project->subscribers);
  }


  public function a_signIn_user_unsubscribe_to_project()
  {
      $this->signIn();
      $project=create("App\Models\Project");
      $this->delete($project->path().'/unsubscribe');
      $this->assertCount(0, $project->subscribers);
  }

}
