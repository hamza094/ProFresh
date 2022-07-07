<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use App\Mail\ProjectMail;
use App\Exports\ProjectsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;
use App\Models\Project;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class FeatureTest extends TestCase
{
  use  RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

     public function setUp() :void
     {
         parent::setUp();
         // create a user
        $user=User::factory()->create([
             'email'=>'johndoe@example.org',
             'password'=>Hash::make('testpassword')
         ]);

         Sanctum::actingAs(
             $user,
         );

         Project::factory()->create(['user_id'=>$user->id]);
     }

    /** @test */
    public function auth_user_can_export_project_file()
    {
       $project=Project::first();
       Excel::fake();
       $this->withoutExceptionHandling()->get('api/v1/projects/'.$project->slug.'/export');

      Excel::assertDownloaded('Project '.$project->name.'.xls', function(ProjectsExport $export) {
          // Assert that the correct export is downloaded.
           return $export->query()->get()->contains('name',Project::first()->name);
       });
   }

    public function project_mail_sent()
    {
      $this->signIn();
      Mail::fake();
      Mail::assertNothingSent();
      $project=create('App\Models\Project');
      $this->withoutExceptionHandling()->post('/api/projects/'.$project->id.'/mail');
      Mail::assertSent(ProjectMail::class, 1);
      $this->assertCount(2,$project->activity);
    }

    public function project_sms_link_working()
    {
      $this->signIn();
      $project=create('App\Models\Project');
      $this->json('POST','/api/projects/'.$project->id.'/sms')->assertStatus(401);
    }
}
