<?php

namespace Tests\Feature;

use DB;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Message;
use App\Traits\ProjectSetup;
use Carbon\Carbon;
use Tests\TestCase;

class MessageTest extends TestCase
{
  use RefreshDatabase,ProjectSetup;

     /** @test */
     public function operation_on_send_message()
     {
       $response=$this->postJson($this->project->path().'/message',[
          'message'=>'this is project message',
          'users'=>json_encode([$this->user->id]),
          'subject'=>'this is message subject',
          'sms'=>true,
          'mail'=>true,
        ]);

        $this->assertDatabaseHas('messages',['type'=>'mail']);

        $this->assertDatabaseHas('messages',['type'=>'sms']);
     }

     /** @test */
     public function message_option_must_be_selected()
     {
       $response=$this->postJson($this->project->path().'/message',[
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
     public function get_project_scheduled_messages()
     {
       $messages=Message::factory()->for($this->project)->count(4)
       ->create(['delivered_at'=>Carbon::now()->addDay(2)]);

       $response=$this->getJson($this->project->path().
        '/messages/scheduled')->assertok();

       $this->assertEquals($this->project->scheduledMessages()->count(),$this->project->messages->count());
     }

     /** @test */
     public function project_message_can_be_deleted()
     {
        $message=Message::factory()->for($this->project)
                 ->create();

        $this->deleteJson($this->project->path().'/messages/'.
               $message->id.'/delete');

        $this->assertModelMissing($message);
     }

}
