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
      Stage::factory()->count(1)->create();
      Stage::factory()->count(1)->define()->create();
      Stage::factory()->count(1)->design()->create();
      Stage::factory()->count(1)->develop()->create();
      Stage::factory()->count(1)->execution()->create();
    }
}
