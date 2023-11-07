<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;
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

        $projects->each(function ($project){
              $user_id = $project->user->id;

            Task::factory()->count(4)->create([
              'project_id'=>$project->id,
              'user_id'=>$user_id,
            ]);

            Task::factory()->count(2)->create([
                'project_id' => $project->id,
                'user_id' => $user_id,
                'deleted_at'=>Carbon::now()->subDays(30),
            ]);
        });
    }
}
