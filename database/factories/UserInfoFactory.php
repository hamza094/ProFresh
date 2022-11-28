<?php

namespace Database\Factories;
use App\Models\UserInfo;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\Factory;

class UserInfoFactory extends Factory
{

  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = UserInfo::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
          'user_id'=>User::factory(),
          'mobile'=>$this->faker->phoneNumber,
          'company'=>$this->faker->company,
          'position'=>$this->faker->jobTitle,
          'address'=>$this->faker->address,
          'bio'=>$this->faker->text($maxNbChars = 1000)
        ];
    }
}
