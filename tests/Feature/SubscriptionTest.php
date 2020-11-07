<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\Lead;


class SubscriptionTest extends TestCase
{
  use RefreshDatabase;

  /** @test */
  public function a_signIn_user_subscribe_to_lead()
  {
      $this->signIn();
      $lead=create("App\Lead");
      $this->post($lead->path().'/subscribe');
      $this->assertCount(1, $lead->subscribers);
  }

  /** @test */
  public function a_signIn_user_unsubscribe_to_lead()
  {
      $this->signIn();
      $lead=create("App\Lead");
      $this->delete($lead->path().'/unsubscribe');
      $this->assertCount(0, $lead->subscribers);
  }

}
