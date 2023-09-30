<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Project;
use App\Traits\ProjectSetup;

class DashboardTest extends TestCase
{
    use RefreshDatabase,ProjectSetup;

    /** @test */
    public function auth_user_can_view_his_projects_on_dashboard()
    {
       $projects=Project::factory()->count(3)->for($this->user)
                 ->create();

       $response=$this->getJson('/api/v1/user/projects');

       $response
        ->assertOk()
        ->assertJson([
            'projects'=>[0=>['name'=>$this->project->name]],
            'projectsCount'=>4
           ]);

       $this->deleteJson($this->project->path());

       $response=$this->getJson('/api/v1/user/projects?abandoned=true')
       ->assertOk();

        $response->assertJson([
            'projects'=>[0=>['name'=>$this->project->name]],
            'projectsCount'=>1
          ]);
    }

}
