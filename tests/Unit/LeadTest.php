<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LeadTest extends TestCase
{
  use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */

     /** @test */
  public function a_lead_can_make_a_string_path(){
    $this->signIn();
      $lead=create('App\Lead');
      $this->assertEquals(
          "/api/leads/{$lead->id}",$lead->path());
  }


/** @test */
  public function a_lead_has_a_creator()
  {
    $this->signIn();
      $lead=create('App\Lead');
      $this->assertInstanceOf('App\User',$lead->user);
  }


  public function it_belongs_to_a_Account()
  {
    $this->signIn();
      $lead = create('App\Lead');
      $this->assertInstanceOf('App\Account', $lead->account);
  }

  /** @test */
  public function a_lead_can_add_a_task()
  {
      $this->signIn();
      $lead=create('App\Lead');
      $lead->addTask('run berry run');
      $this->assertCount(1,$lead->tasks);
  }

  /** @test */
  public function an_lead_can_be_followed_to(){
    $this->signIn();
      $lead=create('App\Lead');
      $lead->subscribe($userId=1);
      $this->assertEquals(1,$lead->subscribers()->where('user_id',$userId)->count());
  }

  /** @test */
public function an_event_can_be_unfollowed_from()
{
  $this->signIn();
   $lead = create('App\Lead');
   $lead->subscribe($userId = 1);
   $lead->unsubscribe($userId);
   $this->assertCount(0, $lead->subscribers);
}

}
