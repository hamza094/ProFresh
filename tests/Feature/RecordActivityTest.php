<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RecordActivityTest extends TestCase
{
  use RefreshDatabase;
    /**
     * A basic feature activity example.
     *
     * @return void
     */

     /** @test */
public function creating_a_lead()
{
  $this->signIn();
    $lead=create('App\Lead');
    $this->assertCount(1,$lead->activity);
   tap($lead->activity->last(), function ($activity) {
         $this->assertEquals('created_lead',$activity->description);
        $this->assertNull($activity->changes);
    });
}

/** @test*/
 public function updating_a_lead()
{
  $this->signIn();
    $lead=create('App\Lead');
    $originalName = $lead->name;
    $lead->update(['name'=>'changed']);
    $this->assertCount(2,$lead->activity);
    tap($lead->activity->last(), function ($activity) use ($originalName) {
        $this->assertEquals('updated_lead',$activity->description);
          $expected = [
            'before' => ['name' => $originalName],
            'after' => ['name' => 'changed']
        ];
        $this->assertEquals($expected, $activity->changes);
    });
}

/** @test */
public function deleting_lead_remove_all_lead_related_activities()
{
  $this->signIn();
    $lead=create('App\Lead');
 $this->get('api/leads/'.$lead->id.'/delete');
$this->assertCount(0,$lead->activity);
}


}
