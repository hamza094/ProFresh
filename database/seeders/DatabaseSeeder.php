<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Project;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       $this->call(StageSeeder::class);
       $this->call(UserSeeder::class);
       //$this->call(InfoSeeder::class);
       //$this->call(MembersSeeder::class);
       $this->call(TaskSeeder::class);
       //$this->call(ConversationSeeder::class);
       //$this->call(NotificationSeeder::class);
    }
}
