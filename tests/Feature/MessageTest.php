<?php

namespace Tests\Feature;

use DB;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Message;
use App\Models\Project;
use Carbon\Carbon;
use Tests\TestCase;

class MessageTest extends TestCase
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

         Project::factory()->has(User::factory()->count(4))
         ->for($user)->create();
     }

     /** @test */
     public function operation_on_send_message()
     {
       $project=Project::first();

       $response=$this->postJson($project->path().'/message',[
          'message'=>'this is project message',
          'users'=>json_encode([User::first()->id]),
          'subject'=>'this is message subject',
          'sms'=>true,
          'mail'=>true,
        ]);

        $this->assertDatabaseHas('messages',['type'=>'mail']);

        $this->assertDatabaseHas('messages',['type'=>'sms']);

        //$message=Message::where('message','this is project message')->get();

        //$this->assertEquals($mail[0]->delivered,1);
     }

     /** @test */
     public function message_option_must_be_selected()
     {
       $project=Project::first();
       $response=$this->postJson($project->path().'/message',[
          'message'=>'this is project message',
          'users'=>json_encode(['71b88a29','42892']),
        ]);
        $response->assertJsonValidationErrors('option');
     }

     /** @test */
     public function check_schedule_command_working(){
           $this->artisan('schedule:message')->assertSuccessful();
     }

     /** @test */
     public function get_project_scheduled_messages(){
       $project=Project::first();

       $messages=Message::factory()->count(4)
       ->create([
         'project_id'=>$project->id,
         'delivered_at'=>Carbon::now()->addDay(2)
       ]);

       $response=$this->getJson($project->path().'/messages/scheduled')->assertStatus(200);

       $this->assertEquals($project->scheduledMessages()->count(),$project->messages->count());
     }

     /** @test */
     public function project_message_can_be_deleted(){
          $project=Project::first();

          $message=Message::factory()->create(['project_id'=>$project->id]);

          $this->deleteJson($project->path().'/messages/'.$message->id.'/delete');

          $this->assertDatabaseMissing('messages',['id'=>$message->id]);
     }

}
