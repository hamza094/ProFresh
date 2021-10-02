<?php

namespace Database\Factories;

use App\Models\Conversation;
use App\Models\User;
use App\Models\Group;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConversationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Conversation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
        'message'=> $this->faker->sentence,
        'user_id'=>User::factory();
        'group_id'=>Group::factory();
        ];
    }
}
