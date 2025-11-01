<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Project;
use App\Notifications\ProjectTask;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $projects = Project::with('tasks', 'members', 'user')->get();

        $projects->each(function ($project) {

            $project->tasks()->each(function ($task) use ($project) {

                foreach ($project->members as $member) {
                    $member->notify(new ProjectTask($project->name, $project->path(),
                        $project->user->getNotifierData()));
                }

            });
        });
    }
}
