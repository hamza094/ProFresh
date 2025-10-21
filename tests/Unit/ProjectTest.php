<?php

namespace Tests\Unit;

use App\Models\Project;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */

    /** @test */
    public function a_project_can_make_a_string_path()
    {
        $project = Project::factory()->create();
        $this->assertEquals(
            "/api/v1/projects/{$project->slug}", $project->path());
    }

    /** @test */
    public function a_project_has_a_creator()
    {
        $project = Project::factory()->create();
        $this->assertInstanceOf('App\Models\User', $project->user);
    }

    /** @test */
    public function project_belongs_to_stage()
    {
        $project = Project::factory()->create();
        $this->assertInstanceOf('App\Models\Stage', $project->stage);
    }

    /** @test */
    public function a_project_can_add_a_task()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $status = TaskStatus::factory()->create();
        $project = Project::factory()->create(['user_id' => $user->id]);
        $project->addTask('run berry run');
        $this->assertCount(1, $project->tasks);
    }

    /** @test */
    public function a_project_has_tasks()
    {
        $project = Project::factory()->create();
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $project->tasks);
    }

    /** @test */
    public function invitation_can_be_sent_to_a_user()
    {
        $project = Project::factory()->create();
        $project->invite($user = User::factory()->create());
        $this->assertTrue($project->members->contains($user));
    }

    protected function addMember($project, $user)
    {
        $project
            ->members()
            ->attach($user, ['active' => true]);
    }
}
