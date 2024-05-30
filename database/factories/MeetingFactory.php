<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Project;
use App\Models\Meeting;
use App\Models\User;
use Carbon\Carbon;

class MeetingFactory extends Factory
{

    protected $model = Meeting::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
        'user_id' => User::factory(),
        'project_id'=>Project::factory(),
        'meeting_id'=>123456,
        'duration' => 30,
        'password' => 'hippopotemus',
        'join_url' => 'https://www.google.com/',
        'start_url' => 'https://www.google.com/',
        'start_time' => Carbon::now(),
        'join_before_host'=>false
        ];
    }
}
