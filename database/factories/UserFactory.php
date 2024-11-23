<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name=$this->faker->name;

        return [
        'name' => $name,
        'username'=>$this->faker->userName,
        'avatar_path'=>"https://eu.ui-avatars.com/api/?name=".$name,
        'email' => $this->faker->unique()->safeEmail,
        //'last_active_at' =>'',
        'email_verified_at' => now(),
        'password' => Hash::make('Berry@999'),
        'remember_token' => Str::random(10)
        ];
    }
}
