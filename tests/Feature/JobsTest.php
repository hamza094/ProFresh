<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Project;
use App\Models\Message;
use App\Jobs\SmsMessage;
use App\Mail\ProjectMail;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use Mockery\MockInterface;
use App\Services\VonageService;

class JobsTest extends TestCase
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
    public function send_mail_job()
    {
      $project=Project::first();
      $message= Message::factory()->create([
            'project_id'=>$project->id,
            'subject'=>'thus is project subject',
            'message'=>'this is project message',
            'type'=>'mail',
            'delivered'=>false,
          ]);
          $message->users()->attach(User::first());
          $user=User::first();
          $job=new \App\Jobs\MailMessage($project,$message,$user);
          Mail::fake();
          $job->handle();
          Mail::assertSent(ProjectMail::class);
    }

    /** @test */
       public function mock_send_sms_job()
       {
         $project=Project::first();
         $message= Message::factory()->create([
               'project_id'=>$project->id,
               'message'=>'this is project message',
               'type'=>'sms',
               'delivered'=>false,
             ]);
             $message->users()->attach(User::first());
             $user=User::first();

         $mock=$this->mock(VonageService::class, function (MockInterface $mock) use ($project,$message) {
        $mock->shouldReceive('send')->twice();
      });

      $smsJob=new SmsMessage($project,$message);

      app(SmsMessage::class)->handle($mock);

      app(VonageService::class)->send($project,$message);
}
}
