<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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
        $response=$this->post('api/projects',
            ['name' => 'Json','email'=>'json_pisces@outlook.com','owner'=>'admin',
                'mobile'=>6785434567]);
          $this->assertDatabaseHas('projects',['name'=>'Json']);
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
    public function auth_user_visit_project(){
        $this->signIn();
        $project=create('App\Project');
        $this->get($project->path())->assertSee($project->id);
    }

    /** @test */
    public function avatar_of_project_can_be_added_by_auth_user()
    {

        $this->json('POST','api/project/1/avatar')
            ->assertStatus(401);
    }

    /** @test */
    public function a_valid_avatar_must_be_provided(){
        $this->signIn();
        $project=create('App\Project');
        $this->json('POST','api/project/'.$project->id.'/avatar',[
            'avatar'=>'not-an-image'
        ])->assertStatus(422);
    }


    public function auth_user_may_add_avatar_to_project()
    {
        $this->signIn();
        $project=create('App\Project');
        Storage::fake('s3');
        $this->json('POST','api/project/'.$project->id.'/avatar',[
            'avatar_path'=>$file=UploadedFile::fake()->image('avatar.jpg')
        ]);

        Storage::disk('s3')->assertExists('avatars/'.$file->hashName());
    }

    /** @test */
    public function a_user_can_determine_their_avatar_path()
    {

      $this->signIn();
        $user=create('App\Project');
        $user->avatar_path='http://localhost/storage/avatars/me.jpg';
        $this->assertEquals(asset('storage/avatars/me.jpg'),$user->avatar_path);
    }

    /** @test */
    public function signIn_user_can_update_project(){
        $this->signIn();
        $project=create('App\Project');
        $name="john santiman";
        $owner='fella';
        $email="james_picaso@outlook.com";
        $mobile=6785434567;
       $this->patch($project->path(),['name'=>$name,'owner'=>$owner,'email'=>$email,'mobile'=>$mobile]);
        $this->assertDatabaseHas('projects',['id'=>$project->id,'owner'=>$owner]);
    }

    /** @test */
    public function project_stage_conversion(){
      $this->signIn();
      $project=create('App\Project');
      $stage=2;
        $this->patch('api/project/'.$project->id.'/stage',[
          'stage'=>$stage
        ]);
      $this->assertDatabaseHas('projects',['id'=>$project->id,'stage'=>$stage]);
   }

   /** @test */
   public function signIn_user_can_update_reason(){
       $this->signIn();
       $project=create('App\Project');
       $reason="Not defined";
       $stage=0;
       $this->patch('api/project/'.$project->id.'/unqualifed',[
         'stage'=>$stage,
         'unqualifed'=>$reason
       ]);
        $this->assertDatabaseHas('projects',['id'=>$project->id,'unqualifed'=>$reason]);
   }

/** @test */
   public function signIn_user_can_trash_project(){
      $this->signIn();
      $project=create('App\Project');
      $this->assertCount(1,$project->get());
      $this->delete($project->path());
      $this->assertCount(0,$project->get());
$this->assertCount(1,$project->withTrashed()->get());
   }

   /** @test */
      public function signIn_user_can_delete_project(){
         $this->signIn();
         $project=create('App\Project');
         $this->get('api/projects/'.$project->id.'/delete');
         $this->assertDatabaseMissing('projects',['id'=>$project->id]);
      }

      /** @test */
         public function signIn_user_can_delete_project_avatar(){
            $this->signIn();
            $project=create('App\Project',['avatar_path'=>'https://encrypted-tbn0.gstatic.com']);
            $this->patch('api/projects/'.$project->id.'/avatar-delete');
            $this->assertDatabaseHas('projects',['avatar_path'=>null]);
            //$this->assertDatabaseMissing('projects',['id'=>$project->id]);
         }

/** @test */
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
public function signIn_user_can_download_project_export()
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
public function sign_In_user_can_update_note(){
  $this->signIn();
  $project=create('App\Project');
  $this->assertDatabaseHas('projects',['notes'=>null]);
  $notes='abra ka dabra';
  $this->withoutExceptionHandling()->patch('api/projects/'.$project->id.'/notes',['notes'=>$notes]);
  $this->assertDatabaseHas('projects',['notes'=>$notes]);
}


}
