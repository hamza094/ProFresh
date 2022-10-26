<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Message;
use App\Jobs\SmsMessage;
use App\Mail\ProjectMail;
use App\Traits\ProjectSetup;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use Mockery\MockInterface;
use App\Services\SendSmsService;

class JobsTest extends TestCase
{
  use RefreshDatabase,ProjectSetup;

    /**
     * Job Tests.
     *
     * @return void
     */

   /** @test */
    public function send_mail_job()
    {
      $message=Message::factory()->for($this->project)
      ->create([
            'subject'=>'thus is project subject',
            'message'=>'this is project message',
            'type'=>'mail',
            'delivered'=>false
        ]);

      $message->users()->attach($this->user);

      $job=new \App\Jobs\MailMessage($this->project,$message,
            $this->user);

       Mail::fake();

       $job->handle();

       Mail::assertSent(ProjectMail::class);
    }

     /** @test */
    public function mock_send_sms_job()
    {
      $project=$this->project;

      $message=Message::factory()->for($project)->
        create([
                 'message'=>'this is project message',
                 'type'=>'sms',
                 'delivered'=>false,
             ]);

       $message->users()->attach($this->user);

       $mock=$this->mock(SendSmsService::class, function (MockInterface $mock) use ($project,$message) {
        $mock->shouldReceive('send')
        ->once()
        //->with($project,$message)
        ->andReturn('https://picsum.photos/200/300');
      });

      $smsJob=new SmsMessage($project,$message);

      app(SmsMessage::class)->handle($mock);
    }
}
