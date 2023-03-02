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
      $userIds = User::pluck('id');

      Project::with('members')->chunk(50, function ($projects) use ($userIds) {
        foreach ($projects as $project) {
        $project->members()->attach($userIds->random(rand(1,4)));
      }});
    }
}
