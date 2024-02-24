<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Project;
use App\Traits\ProjectSetup;
use Illuminate\Support\Facades\DB;

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

    /** @test */
    public function auth_user_view_his_activities()
    {
      $response=$this->getJson('api/v1/user/activities')->assertOk(); 

      $response->assertJsonFragment(['user_id' => $this->user->id]);
    }

    /** @test */
    public function auth_user_get_his_projects_count()
    {
        Project::factory()->create(['user_id'=>$this->user->id]);

        Project::factory()->create(['deleted_at'=>now(),'user_id'=>$this->user->id]);

        $invitedProject = Project::factory()->create();

        DB::table('project_members')->insert([
            'project_id' => $invitedProject->id,
            'user_id' => $this->user->id,
            'active' => 1,
        ]);
        

        $response=$this->getJson('api/v1/data')->assertOk();

        $projectsData = $response->json('projectsData');
         
        $this->assertEquals(2, $projectsData['active_projects']);

        $this->assertEquals(1, $projectsData['trashed_projects']);

        $this->assertEquals(1, $projectsData['active_invited_projects']);

        $this->assertEquals(
            
         array_sum(array_only($projectsData, ['active_projects', 'trashed_projects', 'active_invited_projects'])),

        $projectsData['total_projects']);       

    }



}
