<?php

declare(strict_types=1);

namespace Tests\Feature\Api\V1;

use App\Models\User;
use App\Traits\ProjectSetup;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MessageValidationTest extends TestCase
{
    use ProjectSetup,RefreshDatabase;

    /** @test */
    public function validate_message_errors()
    {
        $users = json_encode(User::factory(2)->create());

        $this->postJson($this->project->path().'/message', ['message' => null, 'users' => $users])
            ->assertUnprocessable()
            ->assertJsonMissingValidationErrors('data.message');
    }

    /** @test */
    public function check_message_option_select()
    {
        $users = json_encode(User::factory(2)->create());

        $this->postJson($this->project->path().'/message',
            ['message' => 'this is my post', 'users' => $users, 'mail' => null, 'sms' => null])
            ->assertUnprocessable()
            ->assertJsonValidationErrors('option');
    }
}
