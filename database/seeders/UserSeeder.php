<?php

namespace Database\Seeders;
use App\Models\User;
use App\Models\Project;
use App\Models\Stage;
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
       User::factory()->count(5)
      ->has(Project::factory()->state([
        'stage_id'=>1
        ])->count(3))->create();
    }
}
