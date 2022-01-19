<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\Conversation;

class ConversationSeeder extends Seeder
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
            Conversation::factory(1)->create([
                'group_id' => $project->group->id,
                'user_id'=>$project->user->id,
            ]);
        });
    }
}
