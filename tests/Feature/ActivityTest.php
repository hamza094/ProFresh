<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Traits\ProjectSetup;
use Tests\TestCase;

class ActivityTest extends TestCase
{
    use RefreshDatabase,ProjectSetup;

    /** @test */
    public function view_activity_by_filters()
    {
      $task=$this->project->addTask('test task');
      $this->filterByProjectSpecified($this->project,$task);
      $this->filterByTasks($this->project,$task);
      $this->filterByAuthUser($this->project);
      $this->noActivitiesExistsError($this->project);
    }

    protected function filterByProjectSpecified($project,$task)
    {
      $response=$this->getJson($project->path().'/activities')
                      ->assertOk();

      $data = $response->json()['data'];
      $this->assertCount(2,$data);
      $this->assertEquals($data[0]['description'],'Project created');
      $this->assertEquals($data[1]['description'],'Task '.$task->body. ' added');
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

      $this->assertEquals($response->json(),['message'=>'No related activities found']);
    }

}
