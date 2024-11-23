<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Stage;

class StageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $stages = ['design', 'develop', 'testing','deliver','completed','postponed'];

        $stageFactory = Stage::factory()->count(1);
        $stageFactory->create();

        foreach ($stages as $stage) {
            $stageFactory->$stage()->create();
        }
    }
}
