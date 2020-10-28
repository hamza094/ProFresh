<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class LeadTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    /** @test */
    public function auth_user_can_create_lead()
    {
        $this->signIn();
        $response=$this->post('api/leads',
            ['name' => 'Json','email'=>'json_pisces@outlook.com','owner'=>'admin',
                'mobile'=>6785434567]);
          $this->assertDatabaseHas('leads',['name'=>'Json']);
    }

    /** @test */
    public function a_lead_requires_a_name(){
        $this->signIn();
        $lead=make('App\Lead',[
            'name'=>null
        ]);
        $this->post('/api/leads',$lead->toArray())
            ->assertSessionHasErrors('name');

    }

    /** @test */
    public function auth_user_visit_lead(){
        $this->signIn();
        $lead=create('App\Lead');
        $this->get($lead->path())->assertSee($lead->id);
    }

    /** @test */
    public function avatar_of_lead_can_be_added_by_auth_user()
    {

        $this->json('POST','api/lead/1/avatar')
            ->assertStatus(401);
    }

    /** @test */
    public function a_valid_avatar_must_be_provided(){
        $this->signIn();
        $lead=create('App\Lead');
        $this->json('POST','api/lead/'.$lead->id.'/avatar',[
            'avatar'=>'not-an-image'
        ])->assertStatus(422);
    }




    public function auth_user_may_add_avatar_to_lead()
    {
        $this->signIn();
        $lead=create('App\Lead');
        Storage::fake('s3');
        $this->json('POST','api/lead/'.$lead->id.'/avatar',[
            'avatar_path'=>$file=UploadedFile::fake()->image('avatar.jpg')
        ]);

        Storage::disk('s3')->assertExists('avatars/'.$file->hashName());
    }

    /** @test */
    public function a_user_can_determine_their_avatar_path()
    {
        $user=create('App\Lead');
        $user->avatar_path='http://localhost/storage/avatars/me.jpg';
        $this->assertEquals(asset('storage/avatars/me.jpg'),$user->avatar_path);
    }

    /** @test */
    public function signIn_user_can_update_lead(){
        $this->signIn();
        $lead=create('App\Lead');
        $name="john santiman";
        $owner='fella';
        $email="james_picaso@outlook.com";
        $mobile=6785434567;


        $this->patch($lead->path(),['name'=>$name,'owner'=>$owner,'email'=>$email,'mobile'=>$mobile]);
        $this->assertDatabaseHas('leads',['id'=>$lead->id,'owner'=>$owner]);
    }

    /** @test */
    public function lead_stage_conversion(){
      $this->signIn();
      $lead=create('App\Lead');
      $stage=2;
        $this->withoutExceptionHandling()->patch('api/lead/'.$lead->id.'/stage',[
          'stage'=>$stage
        ]);
      $this->assertDatabaseHas('leads',['id'=>$lead->id,'stage'=>$stage]);
   }

   /** @test */
   public function signIn_user_can_update_reason(){
       $this->signIn();
       $lead=create('App\Lead');
       $reason="Not defined";
       $stage=0;
       $this->withoutExceptionHandling()->patch('api/lead/'.$lead->id.'/unqualifed',[
         'stage'=>$stage,
         'unqualifed'=>$reason
       ]);
        $this->assertDatabaseHas('leads',['id'=>$lead->id,'unqualifed'=>$reason]);
   }




}