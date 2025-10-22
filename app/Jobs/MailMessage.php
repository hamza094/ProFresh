<?php

namespace App\Jobs;

use App\Mail\ProjectMail;
use App\Models\Project;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class MailMessage implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // public $tries = 3;

    // public $timeout = 60;

    /**
     * The project instance.
     *
     * @var Project
     */
    protected $project;

    protected $message;

    protected $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Project $project, $message, $user)
    {
        $this->project = $project;
        $this->message = $message;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->user)
            ->send(new ProjectMail($this->project, $this->message));
    }
}
