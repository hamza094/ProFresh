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
    public function updated_project_requires_a_name(){
        $user=User::first();
        $project=Project::factory()->create(['user_id'=>$user->id]);
        $this->patchJson($project->path(),['name'=>null])->assertStatus(422);

        /*$this->withoutExceptionHandling()->postJson($project->path(),$project->toArray())
            ->assertSessionHasErrors('name');*/

    }
    /** @test */
    public function auth_user_can_view_project_resource(){
        $project=Project::factory()->create();
        $this->getJson($project->path())->assertSee($project->id)
        ->assertStatus(200);
    }

   /** @test */
    public function auth_user_can_update_project(){
       $user=User::first();
       $project=Project::factory()->create(['user_id'=>$user->id]);
      $name="My First Project";
       $this->withoutExceptionHandling()->patch($project->path(),['name'=>$name]);
        $this->assertDatabaseHas('projects',['id'=>$project->id,'name'=>$name]);
    }

    /** @test */
    public function data_with_same_request_not_be_updated(){
      $project=Project::factory()->create(['name'=>'My Project']);
      $this->patchJson($project->path(),['name'=>'My Project'])->assertStatus(400);
    }

   public function project_owner_can_trash_project(){
     $user=create('App\Models\User');
      $this->signIn($user);
      $project=create('App\Models\Project',['user_id'=>$user->id]);
      $this->assertCount(1,$project->get());
      $this->delete($project->path());
      $this->assertCount(0,$project->get());
$this->assertCount(1,$project->withTrashed()->get());
   }

      public function project_owner_can_delete_project(){
        $user=create('App\Models\User');
         $this->signIn($user);
         $project=create('App\Models\Project',['user_id'=>$user->id]);
         $this->get('api/projects/'.$project->id.'/delete');
         $this->assertDatabaseMissing('projects',['id'=>$project->id]);
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

public function user_can_download_project_export()
{
  $this->signIn();
  $project=create('App\Models\Project',['name'=>'John O Corner']);
    Excel::fake();
    $this->get('api/projects/'.$project->id.'/export');

    Excel::assertDownloaded('project'.$project->id.'.xlsx', function(ProjectsExport $export) {
        // Assert that the correct export is downloaded.
         return $export->query()->get()->contains('name','John O Corner');
    });
}

  /** @test */
  public function auth_user_can_update_note()
  {
    $user=User::first();
    $project=Project::factory()->create(['user_id'=>$user->id]);
    $this->assertDatabaseHas('projects',['notes'=>null]);
    $notes='My Project Notes';
    $this->patchJson($project->path().'/notes',['notes'=>$notes]);
    $this->assertDatabaseHas('projects',['notes'=>$notes]);
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
