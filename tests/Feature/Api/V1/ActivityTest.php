<?php

namespace Tests\Feature\Api\V1;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Traits\ProjectSetup;
use Tests\TestCase;

class ActivityTest extends TestCase
{
    use RefreshDatabase,ProjectSetup;

    /** @test */
    public function it_filters_activities_by_project_specified()
    {
      $task=$this->project->addTask('test task');

      $response=$this->getJson($this->project->path().'/activities')->assertOk();

      $data = $response->json()['data'];
      
      $this->assertCount(2,$data);
      $this->assertEquals($data[0]['description'],'Project created');
      $this->assertEquals($data[1]['description'],'Task '.$task->body. 'added');
    }

    /** @test */
    public function it_filters_activities_by_tasks()
    {
      $task=$this->project->addTask('test task');

      $response=$this->getJson($this->project->path().'/activities?tasks=1')
        ->assertJsonCount(1,['data'])
       ->assertOk();
       
      $this->assertEquals($response->json()['data'][0]['description'],'Task '.$task->body. 'added');
    }

    /** @test */
    public function it_filters_activities_by_authenticated_user()
    {
      $task=$this->project->addTask('test task');

      $response=$this->getJson($this->project->path().'/activities?mine='.$this->project->user->id)->assertOk(); 

      $this->assertEquals($response->json()['data'][0]['description'],'Project created');
    }

    /** @test */
    public function it_shows_error_when_no_related_activities_are_found()
    {
      $task=$this->project->addTask('test task');

      $response=$this->getJson($this->project->path().'/activities?members=1')
      ->assertOk(); 

      $this->assertEquals($response->json(),['message'=>'No related activities found']);
    }

}
