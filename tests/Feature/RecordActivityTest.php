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
public function creating_a_project()
{
  $this->signIn();
    $project=create('App\Project');
    $this->assertCount(1,$project->activity);
   tap($project->activity->last(), function ($activity) {
         $this->assertEquals('created_project',$activity->description);
        $this->assertNull($activity->changes);
    });
}

/** @test*/
 public function updating_a_project()
{
  $this->signIn();
    $project=create('App\Project');
    $originalName = $project->name;
    $project->update(['name'=>'changed']);
    $this->assertCount(2,$project->activity);
    tap($project->activity->last(), function ($activity) use ($originalName) {
        $this->assertEquals('updated_project',$activity->description);
          $expected = [
            'before' => ['name' => $originalName],
            'after' => ['name' => 'changed']
        ];
        $this->assertEquals($expected, $activity->changes);
    });
}

/** @test */
public function deleting_project_remove_all_project_related_activities()
{
  $this->signIn();
    $project=create('App\Project');
 $this->get('api/projects/'.$project->id.'/delete');
$this->assertCount(0,$project->activity);
}


}
