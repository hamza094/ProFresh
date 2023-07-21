<?php

namespace Database\Factories;

use App\Models\Task;
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
        'title'=>$this->faker->catchPhrase,
        'project_id'=>Project::factory(),
        'description'=>$this->faker->text($maxNbChars = 250),
        'status_id'=>1
        ];
    }
}
