<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Project;
use App\Models\Task;
use App\Traits\ProjectSetup;
use Laravel\Sanctum\Sanctum;
use App\Exports\ProjectsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApplicationTest extends TestCase
{
  use RefreshDatabase,ProjectSetup;

     /** @test */
    public function only_allowed_users_access_different_application_features()
    {
      $this->postJson($this->project->path().'/task',
          ['body' => 'My Project Task'])->assertCreated();

          $this->project->invite($user=User::factory()->create());

          Sanctum::actingAs(
             $user,
         );

         $this->getJson($this->project->path().'/accept-invitation')
         ->assertOk();

         $this->postJson($this->project->path().'/task',
          ['body' => 'My Project Task Updated'])->assertCreated();

          Sanctum::actingAs(
             User::factory()->create(),
         );

         $response=$this->postJson($this->project->path().'/task',
          ['body' => 'My Project Task Updated'])->assertForbidden();

          $response->assertJson([
              'message'=>"Only Project's owner and members are allowed to access this feature.",
            ]);
    }

    /** @test */
    public function auth_user_can_export_project_file()
    {
       Excel::fake();
       $this->getJson($this->project->path().'/export');

      Excel::assertDownloaded('Project '.$this->project->name.'.xls', function(ProjectsExport $export) {
          // Assert that the correct export is downloaded.
           return $export->query()->get()->contains('name',Project::first()->name);
       });
    }
}
