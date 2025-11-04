<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Activity;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActivityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Activity::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'project_id' => Project::factory(),
            'description' => $this->faker->randomElement([
                'created_project',
                'updated_project',
                'deleted_project',
                'added_task',
                'completed_task',
                'commented_on_task',
            ]),
            'created_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'updated_at' => function (array $attributes) {
                return $attributes['created_at'];
            },
        ];
    }

    /**
     * Configure the factory to create an activity for a specific user.
     */
    public function forUser(User $user): self
    {
        return $this->state(function (array $attributes) use ($user) {
            return [
                'user_id' => $user->id,
            ];
        });
    }

    /**
     * Configure the factory to create an activity for a specific project.
     */
    public function forProject(Project $project): self
    {
        return $this->state(function (array $attributes) use ($project) {
            return [
                'project_id' => $project->id,
            ];
        });
    }
}
