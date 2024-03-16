<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\User;
use App\Models\Task;
use DB;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Carbon\Carbon;

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
