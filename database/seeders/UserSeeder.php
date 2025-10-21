<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->count(14)
            ->has(Project::factory()
                ->state(['stage_id' => 1])
                ->count(6))
            ->create();
    }
}
