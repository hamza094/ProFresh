<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $projects = Project::with('user')->get();

        $projects->each(function ($project) {
            $user = $project->user;

            Task::factory()->count(6)->create([
                'user_id' => $user->id,
                'project_id' => $project->id,
            ]);

            Task::factory()->trashed()->count(3)->create([
                'user_id' => $user->id,
                'project_id' => $project->id,
            ]);

            Task::factory()->completed()->count(3)->create([
                'user_id' => $user->id,
                'project_id' => $project->id,
            ]);

            Task::factory()->overdue()->count(2)->create([
                'user_id' => $user->id,
                'project_id' => $project->id,
            ]);

            Task::factory()->remaining()->count(3)->create([
                'user_id' => $user->id,
                'project_id' => $project->id,
            ]);
        });

    }
}
