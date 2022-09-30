<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ActivityTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    /** @test */
    public function view_activity_by_filters()
    {
       $project=projectSetup();

       $task=$project->addTask('test task');
        
       $this->filterByProjectSpecified($project,$task);

       $this->filterByTasks($project,$task);

       $this->filterByAuthUser($project);

       $this->noActivitiesExistsError($project);
    }

    protected function filterByProjectSpecified($project,$task)
    {
      $response=$this->getJson($project->path().'/activities')
       ->assertJsonCount(2,['data'])
       ->assertOk();

      $this->assertEquals($response->json()['data'][0]['description'],'Project created');

      $this->assertEquals($response->json()['data'][1]['description'],'Task '.$task->body. ' added');
    }

    protected function filterByTasks($project,$task)
    {
      $response=$this->getJson($project->path().'/activities?tasks=1')
        ->assertJsonCount(1,['data'])
       ->assertOk();


      $this->assertEquals($response->json()['data'][0]['description'],'Task '.$task->body. ' added');
    }

    protected function filterByAuthUser($project)
    {
      $response=$this->getJson($project->path().'/activities?mine='.$project->user->id)->assertOk(); 

      $this->assertEquals($response->json()['data'][0]['description'],'Project created');
    }

    protected function noActivitiesExistsError($project)
    {
      $response=$this->getJson($project->path().'/activities?members=1')
      ->assertOk(); 

      $this->assertEquals($response->json(),'No related activities found');
    }


}
