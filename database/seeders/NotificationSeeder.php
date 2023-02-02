<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Notifications\ProjectTask;
use App\Models\Project;
use App\Models\User;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $projects = Project::with('tasks','members','user')->get();

      $projects->each(function ($project){

        $project->tasks()->each(function ($task) use ($project) {

          foreach($project->members as $member){
            $member->notify(new ProjectTask($project,$project->user->toArray()));
          }

        });
      });
    }
}
