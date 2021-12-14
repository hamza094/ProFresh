<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\Conversation;
use App\Models\User;

class ConversationSeeder extends Seeder
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

        $projects->each(function ($project) use ($users) {
            Conversation::factory(1)->create([
                'group_id' => $project->group->id,
            ])->each(function($conversation) use($project) {
                $conversation->update(['user_id'=>$project->user->id]);
            });
        });
    }
}
