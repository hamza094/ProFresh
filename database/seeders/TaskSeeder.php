<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Sequence;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $projects = Project::all();

        $projects->each(function ($project){
            Task::factory(4)
            ->state(new Sequence(
                ['completed' => 0],
                ['completed' => 1],
              ))
              ->create(['project_id'=>$project->id]);
        });
    }
}
