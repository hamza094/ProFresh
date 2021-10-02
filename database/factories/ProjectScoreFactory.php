<?php

namespace Database\Factories;

use App\Models\ProjectScore;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectScoreFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProjectScore::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
        'project_id'=>Project::factory();
        'message' => 'hy berry',
        'point'=>'Admin'
        ];
    }
}
