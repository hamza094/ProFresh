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
      $projects = Project::with('user')->get();

        $projects->each(function ($project){
            Conversation::factory(3)->for($project)
            ->create([
                'user_id'=>$project->user->id,
            ]);
        });
    }
}
