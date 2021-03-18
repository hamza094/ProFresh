<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Mail;
use App\Mail\ProjectMail;
use App\Exports\ProjectsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\User;

class ProjectTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    /** @test */
    public function auth_user_can_create_project()
    {
        $this->signIn();
        $response=$this->withoutExceptionHandling()->post('api/projects',
            ['name' => 'Json','email'=>'json_pisces@outlook.com',
                'mobile'=>6785434567]);
          $this->withoutExceptionHandling()->assertDatabaseHas('projects',['name'=>'Json']);
    }

    /** @test */
   public function a_project_requires_a_name(){
        $this->signIn();
        $project=make('App\Project',[
            'name'=>null
        ]);
        $this->post('/api/projects',$project->toArray())
            ->assertSessionHasErrors('name');

    }

     /** @test */
    public function updated_project_requires_a_name(){
        $this->signIn();
        $project=make('App\Project',[
            'name'=>null
        ]);
        $this->post('/api/projects',$project->toArray())
            ->assertSessionHasErrors('name');

    }

    /** @test */
    public function auth_user_visit_project(){
        $this->signIn();
        $project=create('App\Project');
        $this->get($project->path())->assertSee($project->id);
    }



    /** @test */
    public function authorized_user_can_update_project(){
      $user=create('App\User');
       $this->signIn($user);
       $project=create('App\Project',['user_id'=>$user->id]);
        $name="john santiman";
        $email="james_picaso@outlook.com";
        $mobile=6785434567;
       $this->withoutExceptionHandling()->patch($project->path(),['name'=>$name,'email'=>$email,'mobile'=>$mobile]);
        $this->assertDatabaseHas('projects',['id'=>$project->id,'mobile'=>$mobile]);
    }

    /** @test */
    public function authorized_user_can_change_project_stage(){
      $user=create('App\User');
       $this->signIn($user);
       $project=create('App\Project',['user_id'=>$user->id]);

      $stage=2;
        $this->patch('api/project/'.$project->id.'/stage',[
          'stage'=>$stage
        ]);
      $this->assertDatabaseHas('projects',['id'=>$project->id,'stage'=>$stage]);
   }

   /** @test */
   public function authorized_user_can_update_reason(){
     $user=create('App\User');
      $this->signIn($user);
      $project=create('App\Project',['user_id'=>$user->id]);
       $reason="Not defined";
       $stage=0;
       $this->patch('api/project/'.$project->id.'/postponed',[
         'stage'=>$stage,
         'postponed'=>$reason
       ]);
        $this->assertDatabaseHas('projects',['id'=>$project->id,'postponed'=>$reason]);
   }

/** @test */
   public function project_owner_can_trash_project(){
     $user=create('App\User');
      $this->signIn($user);
      $project=create('App\Project',['user_id'=>$user->id]);
      $this->assertCount(1,$project->get());
      $this->delete($project->path());
      $this->assertCount(0,$project->get());
$this->assertCount(1,$project->withTrashed()->get());
   }

   /** @test */
      public function project_owner_can_delete_project(){
        $user=create('App\User');
         $this->signIn($user);
         $project=create('App\Project',['user_id'=>$user->id]);
         $this->get('api/projects/'.$project->id.'/delete');
         $this->assertDatabaseMissing('projects',['id'=>$project->id]);
      }


public function project_mail_sent(){
      $this->signIn();
      Mail::fake();
     Mail::assertNothingSent();
    $project=create('App\Project');
       $this->withoutExceptionHandling()->post('/api/projects/'.$project->id.'/mail');
       Mail::assertSent(ProjectMail::class, 1);
       $this->assertCount(2,$project->activity);

}


public function project_sms_link_working(){
  $this->signIn();
  $project=create('App\Project');
  $this->json('POST','/api/projects/'.$project->id.'/sms')->assertStatus(401);
}


/**
* @test
*/
public function user_can_download_project_export()
{
  $this->signIn();
  $project=create('App\Project',['name'=>'John O Corner']);
    Excel::fake();
    $this->get('api/projects/'.$project->id.'/export');

    Excel::assertDownloaded('project'.$project->id.'.xlsx', function(ProjectsExport $export) {
        // Assert that the correct export is downloaded.
         return $export->query()->get()->contains('name','John O Corner');
    });
}

/** @test */
public function authorize_user_can_update_note(){
  $user=create('App\User');
   $this->signIn($user);
   $project=create('App\Project',['user_id'=>$user->id]);
  $this->assertDatabaseHas('projects',['notes'=>null]);
  $notes='abra ka dabra';
  $this->patch('api/projects/'.$project->id.'/notes',['notes'=>$notes]);
  $this->assertDatabaseHas('projects',['notes'=>$notes]);
}

        /** @test */
    public function group_deleted_on_user_deletion()
    {
      $user=create('App\User');
       $this->signIn($user);
        $group=create('App\Group');
     $group->users()->attach($user);
     $user->delete();
      $this->assertDatabaseMissing('groups',['id'=>$group->id]);
}


}
