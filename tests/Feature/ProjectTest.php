<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Mail;
use App\Mail\ProjectMail;
use App\Exports\ProjectsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;
use App\Models\Project;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class ProjectTest extends TestCase
{
    use RefreshDatabase;
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

    public function auth_user_can_create_project()
    {
        $this->signIn();
        $response=$this->post('api/projects',
            ['name' => 'Json','email'=>'json_pisces@outlook.com',
                'mobile'=>6785434567]);
          $this->withoutExceptionHandling()->assertDatabaseHas('projects',['name'=>'Json']);
    }

    public function a_project_requires_a_name(){
        $this->signIn();
        $project=make('App\Models\Project',[
            'name'=>null
        ]);
        $this->post('/api/projects',$project->toArray())
            ->assertSessionHasErrors('name');

    }
     /** @test */
    public function updated_project_requires_a_name()
    {
       $project=Project::first();

       $response=$this->patchJson($project->path(),['name'=>null])->assertStatus(422);

       $response->assertJsonMissingValidationErrors('project.name');
    }

    /** @test */
    public function auth_user_can_get_project_resource()
    {
        $project=Project::factory()->create();

        $response=$this->getJson($project->path())->assertStatus(200);

        $response->assertJson([
            'id'=>$project->id,
            'name'=>$project->name,
           ]);
    }

   /** @test */
    public function auth_user_can_update_project()
    {
       $project=Project::first();

       $name="My First Project";
       $notes="My project first notes";

       $response=$this->patchJson($project->path(),['name'=>$name,
       'notes'=>$notes]);

       $this->assertDatabaseHas('projects',['id'=>$project->id,'name'=>$name]);

       $project->refresh();

       $response->assertJson([
           'msg'=>'Project name updated sucessfully',
           'name'=>$project->name,
           'slug'=>$project->slug
          ]);
    }

    /** @test */
    public function data_with_same_request_not_be_updated()
    {
      $project=Project::first();

      $response=$this->patchJson($project->path(),['name'=>$project->name])
      ->assertStatus(400);

      $response->assertJson([
          'error'=>"You haven't changed anything",
         ]);
    }

   /** @test*/
   public function project_owner_can_trash_project(){
     $user=User::first();
      $project=Project::first();
      $this->assertCount(1,$user->projects()->get());
      $this->deleteJson($project->path());
      $this->assertCount(0,$user->projects()->get());
      $this->assertCount(1,$user->projects()->withTrashed()->get());
   }

   /** @test*/
   public function project_owner_can_restore_project(){
      $user=User::first();
      $project=Project::factory()->create(['user_id'=>$user->id,'deleted_at'=>Carbon::now()]);
      $this->getJson($project->path().'/restore')->assertStatus(200);
      $project->refresh();
      $this->assertCount(0,$user->projects()->onlyTrashed()->get());
      $this->assertEquals($project->deleted_at,null);
   }

      /** @test */
      public function project_owner_can_delete_project(){
        $project= Project::first();
        $this->getJson($project->path().'/delete');
         $this->assertDatabaseMissing('projects',['id'=>$project->id]);
      }

      /** @test */
      public function delete_abandon_projects_after_limit_past(){
        $user=User::first();
        $project=Project::factory()->create(['user_id'=>$user->id,'deleted_at'=>Carbon::now()]);
        $this->assertCount(1,$user->projects()->onlyTrashed()->get());
        $project=Project::factory()->create(['user_id'=>$user->id,'deleted_at'=>Carbon::now()->subDays(91)]);
        $this->assertCount(2,$user->projects()->onlyTrashed()->get());
        $this->artisan('remove:abandon')->assertSuccessful();
        $this->assertCount(1,$user->projects()->onlyTrashed()->get());
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

public function project_mail_sent(){
      $this->signIn();
      Mail::fake();
     Mail::assertNothingSent();
    $project=create('App\Models\Project');
       $this->withoutExceptionHandling()->post('/api/projects/'.$project->id.'/mail');
       Mail::assertSent(ProjectMail::class, 1);
       $this->assertCount(2,$project->activity);
}

public function project_sms_link_working(){
  $this->signIn();
  $project=create('App\Models\Project');
  $this->json('POST','/api/projects/'.$project->id.'/sms')->assertStatus(401);
}

    public function group_deleted_on_user_deletion()
    {
      $user=create('App\Models\User');
       $this->signIn($user);
        $group=create('App\Models\Group');
     $group->users()->attach($user);
     $user->delete();
      $this->assertDatabaseMissing('groups',['id'=>$group->id]);
}
}
