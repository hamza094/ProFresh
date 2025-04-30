<?php

namespace Database\Factories;

use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DatabaseNotificationFactory extends Factory
{
    protected $model = DatabaseNotification::class;

    public function definition()
    {
        return [
            'id' => (string) Str::uuid(),
            'type' => 'App\\Notifications\\ProjectInvitation',
            'notifiable_type' => User::class,
            'notifiable_id' => User::factory(),
            'data' => [
                'message' => 'You have been invited to a project.',
                'project_id' => $this->faker->uuid,
            ],
            'read_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}