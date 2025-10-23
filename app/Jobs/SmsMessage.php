<?php

namespace App\Jobs;

use App\Models\Message;
use App\Models\Project;
use App\Services\Api\V1\SendSmsService;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
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
    // private $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Project $project, private Message $message)
    {
        $this->project = $project;
        // $this->user=$user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(SendSmsService $service)
    {
        $service->send($this->project, $this->message);
    }
}
