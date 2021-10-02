<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Company::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
        'user_id'=>User::factory();
        'name' => $this->faker->paragraph($nbSentences = 3, $variableNbSentences = true),
        'about'=>$this->faker->company,
        'country'=>$this->faker->country, 
        'address'=>$this->faker->address,
        'email'=>$this->faker->unique()->safeEmail,
        'phone_number'=>$this->faker->tollFreePhoneNumber
        ];
    }
}
