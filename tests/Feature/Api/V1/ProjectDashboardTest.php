<?php

namespace Tests\Feature\Api\V1;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Traits\ProjectSetup;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;

class ProjectDashboardTest extends TestCase
{
    use RefreshDatabase, ProjectSetup;

    /** @test */
    public function it_validates_sort_parameter()
    {
        $response = $this->getJson(route('user.projects', ['sort' => 'invalid_sort']));

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['sort'])
            ->assertJson([
                'message' => 'Validation Error',
                'errors' => [
                    'sort' => ['Sort must be either latest or oldest']
                ]
            ]);
    }

    /** @test */
    public function it_validates_member_parameter()
    {
        $response = $this->getJson(route('user.projects', ['member' => 'not_a_boolean']));

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['member'])
            ->assertJson([
                'message' => 'Validation Error',
                'errors' => [
                    'member' => ['The member field must be true or false.']
                ]
            ]);
    }

    /** @test */
    public function it_validates_page_parameter()
    {
        $response = $this->getJson(route('user.projects', ['page' => 0]));

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['page'])
            ->assertJson([
                'message' => 'Validation Error',
                'errors' => [
                    'page' => ['Page must be at least 1']
                ]
            ]);
    }

    /** @test */
    public function it_accepts_valid_parameters()
    {
        Project::factory()->create(['name' => 'Test Project', 'user_id' => $this->user->id]);
        
        $response = $this->getJson(route('user.projects', [
            'sort' => 'latest',
            'member' => true,    
            'abandoned' => false, 
            'page' => 1,         
            'search' => 'Test'
        ]));

        $response->assertOk()
            ->assertJsonMissingValidationErrors(['sort', 'member', 'abandoned', 'page', 'search']);
    }

    /** @test */
    public function auth_user_can_filter_projects_by_search()
    {
        // Create projects with different names
        Project::factory()->create(['name' => 'Frontend Project', 'user_id' => $this->user->id]);
        Project::factory()->create(['name' => 'Backend Project', 'user_id' => $this->user->id]);
        Project::factory()->create(['name' => 'Mobile App', 'user_id' => $this->user->id]);

        $response = $this->getJson(route('user.projects', ['search' => 'Frontend']));

        $response->assertOk();

        $projects = $response->json('projects.data');

        // The search should only return "Frontend Project"
        $this->assertCount(1, $projects);
        $this->assertEquals('Frontend Project', $projects[0]['name']);
    }


    /** @test */
    public function auth_user_can_sort_projects_by_latest()
    {
        $oldProject = Project::factory()->create([
            'name' => 'Old Project',
            'user_id' => $this->user->id,
            'created_at' => now()->subDays(5)
        ]);

        $latestProject = $this->project; // Assuming this is the default project created in ProjectSetup

        $response = $this->getJson(route('user.projects', ['sort' => 'latest']));
        $projects = $response->json('projects.data');
        $this->assertEquals($latestProject->name, $projects[0]['name']);
    }

    /** @test */
    public function auth_user_can_sort_projects_by_oldest()
    {
        $oldProject = Project::factory()->create([
            'name' => 'Old Project',
            'user_id' => $this->user->id,
            'created_at' => now()->subDays(5)
        ]);

        $latestProject = $this->project; // Assuming this is the default project created in ProjectSetup

        $response = $this->getJson(route('user.projects', ['sort' => 'oldest']));
        $projects = $response->json('projects.data');
        $this->assertEquals('Old Project', $projects[0]['name']);
    }

    /** @test */
    public function auth_user_can_view_member_projects()
    {
        // Create a project owned by another user
        $otherUser = User::factory()->create();
        $memberProject = Project::factory()->create(['user_id' => $otherUser->id]);

        // Add current user as member
        DB::table('project_members')->insert([
            'project_id' => $memberProject->id,
            'user_id' => $this->user->id,
            'active' => 1,
        ]);

        $response = $this->getJson(route('user.projects', ['member' => true]));

        $response->assertOk();

        $projects = $response->json('projects.data');

        $this->assertCount(1, $projects);
        $this->assertEquals($memberProject->name, $projects[0]['name']);
    }

    /** @test */
    public function auth_user_can_view_trashed_projects()
    {
        // Soft delete the default project
        $this->project->delete();

        $response = $this->getJson(route('user.projects', ['abandoned' => true]));

        $response->assertOk();

        $projects = $response->json('projects.data');

        $this->assertCount(1, $projects);
        $this->assertEquals($this->project->name, $projects[0]['name']);
    }
}
