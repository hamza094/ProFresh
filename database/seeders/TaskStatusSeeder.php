<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TaskStatus;

class TaskStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TaskStatus::factory()->create(); 
        TaskStatus::factory()->started()->create();
        TaskStatus::factory()->progress()->create();
        TaskStatus::factory()->completed()->create();

    }
}
