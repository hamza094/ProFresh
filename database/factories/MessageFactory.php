<?php

namespace Database\Factories;
use App\Models\Project;
use App\Models\Message;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\Factory;

class MessageFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = Message::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
          'project_id'=>Project::factory(),
          'type'=>'mail',
          'subject'=>$this->faker->sentence,
          'message'=>$this->faker->text($maxNbChars = 250),
          'delivered'=>false,
        ];
    }
}
