<?php

namespace Database\Seeders;
use App\Models\User;
use App\Models\Project;
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
       User::factory()->count(15)
      ->has(Project::factory()->count(3))->create();
    }
}