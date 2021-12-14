<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Appointment;
use App\Models\User;
use App\Models\Project;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $users= User::all();
      $projects = Project::all();

        $projects->each(function ($project) use ($users) {
            Appointment::factory(2)->create([
                'project_id' => $project->id
            ])->each(function($appointment) use($project) {
                $appointment->users()->attach($project->user);
            });
        });
    }
}
