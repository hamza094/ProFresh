<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Project;

class RemoveAbondonProjects extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remove:abandon';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove abandoned projects who has passed limit days';

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
    public function handle()
    {
      $projects=Project::onlyTrashed()
        ->pastAbandonedLimit()
        ->get();

      $projects->each(function($project){
        $project->forceDelete();
      });

    }
}
