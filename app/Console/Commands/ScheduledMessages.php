<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Message;
use App\Services\Api\V1\MessageService;
use Illuminate\Support\Facades\Bus;

class ScheduledMessages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:message';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Scheduled project messages to users';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(MessageService $service)
    {
      $messages=Message::messageScheduled()->with('project','users')->get();

      foreach($messages as $message)
      {
        $project=$message->project;
        $service->sendNow($project,$message);
      }
    }

}
