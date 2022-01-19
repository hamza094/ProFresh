<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\Group;

class GroupSeeder extends Seeder
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
            Group::factory(1)->create([
                'project_id' => $project->id,
                'name'=>$project->name.' '.'Group'
            ])->each(function($group) use($project) {
                $group->users()->attach($project->user);
                $project->update(['group_id'=>$group->id]);
            });
        });
    }
}
