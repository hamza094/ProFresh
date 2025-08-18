<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use App\Models\TaskStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
        'title' => $this->faker->text(55),
        'user_id'=>User::factory(),
        'project_id'=>Project::factory(),
        'description'=>$this->faker->text($maxNbChars = 250),
        'status_id'=>1
        ];
    }

     public function configure()
    {
        return $this->afterCreating(function (Task $task) {
            $assignees = User::inRandomOrder()->limit(rand(1, 3))->get();
            $task->assignee()->attach($assignees);
        });
    }

    public function overdue(): Factory
    {
        return $this->state(function (array $attributes) {
        return [
            'due_at' => Carbon::now()->subDays($this->faker->numberBetween(3, 28)),
        ];
    });      
    }

    public function completed(): Factory
    {
       return $this->state(function (array $attributes) {
        return [
            'status_id'=>4,
            'due_at' => Carbon::now()->addDays($this->faker->numberBetween(1, 5)),
        ];
    });
    }
     
     public function remaining(): Factory
    {
       return $this->state(function (array $attributes) {
        return [
            'status_id'=>2,
            'due_at' => Carbon::now()->addDays($this->faker->numberBetween(5, 30)),
        ];
    });
    }

}
