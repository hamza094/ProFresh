<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppointmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Appointment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
        'project_id'=>Project::factory(),
        'title' => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
        'location'=>$this->faker->address,
        'outcome'=>'intrested',
        'strtdt'=>$this->faker->date($format = 'Y-m-d', $min = 'now'),
        'strttm'=>$this->faker->time($format = 'H:i:s', $min = 'now'),
        'zone'=>$this->faker->timezone
        ];
    }
}
