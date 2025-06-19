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
            'project_id' => Project::factory(),
            'meeting_id' => $this->faker->unique()->numberBetween(1000000000, 9999999999),
            'topic' => $this->faker->sentence(4),
            'agenda' => $this->faker->sentence(8),
            'duration' => $this->faker->randomElement([15, 30, 45, 60]),
            'password' => $this->faker->lexify('???????'),
            'join_url' => $this->faker->url(),
            'start_url' => $this->faker->url(),
            'start_time' => $this->faker->dateTimeBetween('-1 month', '+1 month'),
            'status' => $this->faker->randomElement(['waiting', 'started', 'ended']),
            'join_before_host' => $this->faker->boolean(),
            'timezone' => $this->faker->timezone(),
        ];
    }
}
