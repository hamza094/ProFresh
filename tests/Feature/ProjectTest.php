<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Project;
use App\Traits\ProjectSetup;
use Carbon\Carbon;

class ProjectTest extends TestCase
{
    use RefreshDatabase,ProjectSetup;

    /** @test */
    public function auth_user_can_create_project()
    {
        $response=$this->postJson('api/v1/projects',
           [
            'name' => 'My Project name',
            'about'=>'about this project',
            'stage_id'=>1,
       ]);

       $this->assertDatabaseHas('projects',['name'=>'My Project name']);
    }

    /** @test */
    public function tasks_can_be_added_when_new_project_created()
    {
       $attributes=Project::factory()->raw([
        'user_id'=>auth()->id()
       ]);

       $attributes['tasks']=[
        [
          'title'=>'task 1',
        ],
           ['title'=>'task 2']
        ];

       $response=$this->postJson('api/v1/projects',$attributes);
        
       $project = Project::where('slug', '=', $response->json('project.slug'))->firstOrFail();       

       $this->assertCount(2,$project->tasks);
    }

    /** @test */
    public function project_requires_a_name()
    {
      $project=Project::factory()->make(['name'=>null]);

      $response=$this->postJson('/api/v1/projects',$project->toArray());

      $response->assertJsonValidationErrors('name');
    }

    /** @test */
    public function tasks_validated_on_creating_a_new_project()
    {
       $response = $this->postJson('/api/v1/projects', [
        'name'=>'project name',
        'about'=>'about this project',
        'stage_id'=>1,
         'tasks' => [
             ['title' => str_repeat('a', 56)],
             ['title' => ''],
         ],
       ]);

        $response->assertJsonValidationErrors('tasks.0.title');
        $response->assertJsonValidationErrors('tasks.1.title');
    }

     /** @test */
    public function updated_project_requires_a_name()
    {
      $response=$this->patchJson($this->project->path(),
        ['name'=>null])->assertUnprocessable();

      $response->assertJsonMissingValidationErrors('project.name');
    }

    /** @test */
    public function auth_user_can_get_project_resource()
    {
      $response=$this->getJson($this->project->path())
      ->assertOk();

      $response->assertJson([
            'id'=>$this->project->id,
            'name'=>$this->project->name,
        ]);
    }

   /** @test */
    public function allowed_user_can_update_project()
    {
      $name="My First Project";
      $notes="My project first notes";

      $response=$this->patchJson($this->project->path(),
        ['name'=>$name,'notes'=>$notes]);

       $this->assertDatabaseHas('projects',['id'=>$this->project->id,
        'name'=>$name]);

       $this->project->refresh();

       $response->assertJson([
           'message'=>'Project name updated sucessfully',
           'name'=>$this->project->name,
           'slug'=>$this->project->slug
        ]);
    }

    /** @test */
    public function data_with_same_request_not_be_updated()
    {
      $response=$this->patchJson($this->project->path(),
        ['name'=>$this->project->name])->assertStatus(400);

      $response->assertJson([
          'error'=>"You haven't changed anything",
         ]);
    }

   /** @test*/
   public function project_owner_can_get_abandoned_project()
   {
     $this->assertCount(1,$this->user->projects()->get());

     $this->deleteJson($this->project->path());

     $this->assertCount(0,$this->user->projects()->get());

     $this->assertSoftDeleted($this->project);
   }

   /** @test*/
   public function project_owner_can_restore_project()
   {
     $this->project->touch('deleted_at');

      $this->getJson($this->project->path().'/restore')->assertOk();

      $this->project->refresh();

      $this->assertNotSoftDeleted($this->project);

      $this->assertEquals($this->project->deleted_at,null);
   }

      /** @test */
      public function project_owner_can_delete_project()
      {
        $this->getJson($this->project->path().'/delete');

        $this->assertModelMissing($this->project);
      }

      /** @test */
      public function delete_abandon_projects_after_limit_past()
      {
        $this->project->touch('deleted_at');

        $this->assertCount(1,$this->user->projects()
            ->onlyTrashed()->get());

        $project=Project::factory()
        ->for($this->user)
        ->create(['deleted_at'=>Carbon::now()->subDays(91)]);

        $this->assertCount(2,$this->user->projects()
            ->onlyTrashed()->get());

        $this->artisan('remove:abandon')->assertSuccessful();

        $this->assertCount(1,$this->user->projects()
            ->onlyTrashed()->get());
      }
}
