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
      Stage::factory()->count(1)->create();
      Stage::factory()->create(['name'=>' Defining']);
      Stage::factory()->create(['name'=>'Designing']);
      Stage::factory()->create(['name'=>'Developing']);
      Stage::factory()->create(['name'=>'Execution']);

       User::factory()->count(15)
      ->has(Project::factory()->count(3))->create();

    }
}
