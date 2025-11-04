<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Conversation;
use App\Models\Project;
use Illuminate\Database\Seeder;

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

        $projects->each(function ($project) {
            Conversation::factory(30)->for($project)
                ->create([
                    'user_id' => $project->user->id,
                ]);
        });
    }
}
