<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Meeting;
use App\Models\Project;
use Illuminate\Database\Seeder;

class MeetingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // For each project, create 5 meetings
        Project::all()->each(function ($project) {
            Meeting::factory()->count(5)->create([
                'project_id' => $project->id,
                'user_id' => $project->user_id, // or assign randomly if needed
            ]);
        });
    }
}
