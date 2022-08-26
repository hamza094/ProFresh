<?php

namespace App\Jobs;

use App\Models\Project;
use App\Models\Message;
use App\Services\VonageService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use App\Http\Requests\MessageRequest;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Bus\Batchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SmsMessage implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The project instance.
     *
     * @var \App\Models\Podcast
     */
     private $project;
     private $message;
     //private $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
     public function __construct(Project $project,Message $message)
     {
       $this->project=$project;
       $this->message=$message;
       //$this->user=$user;
     }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(VonageService $vonage)
    {
      $vonage->send($this->project,$this->message);
    }
}
