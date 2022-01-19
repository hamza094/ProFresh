<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserInfo;
use App\Models\User;

class InfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $users= User::all();

      $users->each(function ($user) {
        UserInfo::factory()
            ->for($user)
            ->create();
      });

    }
}
