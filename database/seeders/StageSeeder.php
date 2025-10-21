<?php

namespace Database\Seeders;

use App\Models\Stage;
use Illuminate\Database\Seeder;

class StageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $stages = ['design', 'develop', 'testing', 'deliver', 'completed', 'postponed'];

        $stageFactory = Stage::factory()->count(1);
        $stageFactory->create();

        foreach ($stages as $stage) {
            $stageFactory->$stage()->create();
        }
    }
}
