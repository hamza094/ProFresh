<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(AppointmentSeeder::class);
        $this->call(TaskSeeder::class);
        $this->call(GroupSeeder::class);
        $this->call(ConversationSeeder::class);
        $this->call(ProjectSeeder::class);
        $this->call(CompanySeeder::class);
        $this->call(NotificationSeeder::class);
    }
}
