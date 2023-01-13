<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\User;

class MembersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users= User::all();
        $projects = Project::all();

          foreach ($projects as $project) {

          $project->members()->attach($users->random(rand(1,4)));

          \DB::table('project_members')->where('project_id', $project->id)->update(['active' =>true]);

        };
    }
}
