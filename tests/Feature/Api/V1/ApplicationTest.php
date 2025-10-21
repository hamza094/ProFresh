<?php

namespace Tests\Feature\Api\V1;

use App\Exports\ProjectsExport;
use App\Models\User;
use App\Traits\ProjectSetup;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;

class ApplicationTest extends TestCase
{
    use ProjectSetup,RefreshDatabase;

    /** @test */
    public function only_allowed_users_can_access_project_features()
    {
        $this->withoutExceptionHandling()->postJson($this->project->path().'/tasks',
            ['title' => 'My Project Task'])->assertCreated();

        $this->project->invite($user = User::factory()->create());

        Sanctum::actingAs($user);

        $this->getJson($this->project->path().'/accept-invitation')->assertOk();

        $this->postJson($this->project->path().'/tasks',
            ['title' => 'My Project Task Updated'])->assertCreated();

        Sanctum::actingAs(User::factory()->create());

        $this->expectException(AuthorizationException::class);

        $response = $this->postJson($this->project->path().
           '/tasks');
    }

    /** @test */
    public function auth_user_can_export_project_file()
    {
        Excel::fake();
        $this->getJson($this->project->path().'/export');

        Excel::assertDownloaded('Project '.$this->project->name.'.xls', function (ProjectsExport $export) {

            // Assert that the correct export is downloaded.
            return $export->query()->get()->contains('name', $this->project->name);
        });
    }
}
