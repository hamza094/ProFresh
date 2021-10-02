<?php

namespace Tests;

use App\Exceptions\Handler;
use App\Models\User;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

      protected function setUp() :void
    {
        parent::setUp();
    }

    protected function login(array $attributes = []): User
    {
        $user = $this->createUser($attributes);

        $this->be($user);

        return $user;
    }

    protected function loginAs(User $user)
    {
        $this->be($user);
    }

     protected function createUser(array $attributes = []): User
    {
        return User::factory()->create(array_merge([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password'),
        ], $attributes));
    }
}


