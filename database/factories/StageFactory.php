<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Stage;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class StageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Stage::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => 'Planing',
            'user_id' => User::factory(),
        ];
    }

    public function design()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Design',
                'user_id' => User::factory(),
            ];
        });
    }

    public function develop()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Develop',
                'user_id' => User::factory(),

            ];
        });
    }

    public function testing()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Testing',
                'user_id' => User::factory(),
            ];
        });
    }

    public function deliver()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Deliver',
                'user_id' => User::factory(),
            ];
        });
    }

    public function completed()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Completed',
                'user_id' => User::factory(),
            ];
        });
    }

    public function postponed()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Postponed',
                'user_id' => User::factory(),
            ];
        });
    }
}
