<?php

namespace Database\Factories;

use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskStatusFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TaskStatus::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'label' => 'Not Started',
            'color' => '#CCCCCC',
            'user_id' => User::factory(),

        ];
    }

    public function started()
    {
        return $this->state(function (array $attributes) {
            return [
                'label' => 'Started',
                'color' => '#FFD700',
                'user_id' => User::factory(),

            ];
        });
    }

    public function progress()
    {
        return $this->state(function (array $attributes) {
            return [
                'label' => 'In Progress',
                'color' => '#0000FF',
                'user_id' => User::factory(),

            ];
        });
    }

    public function completed()
    {
        return $this->state(function (array $attributes) {
            return [
                'label' => 'Completed',
                'color' => '#00FF00',
                'user_id' => User::factory(),

            ];
        });
    }
}
