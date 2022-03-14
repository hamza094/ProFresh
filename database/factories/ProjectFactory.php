<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use App\Models\Stage;
use App\Models\Group;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Project::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
        'user_id'=>User::factory(),
        'stage_id'=>Stage::factory(),
        'group_id'=>0,
        'completed'=>false,
        'name' => $this->faker->catchPhrase,
        'about'=>$this->faker->text($maxNbChars = 250),
        'stage_updated_at'=>Carbon::now(),
        ];
    }
}
