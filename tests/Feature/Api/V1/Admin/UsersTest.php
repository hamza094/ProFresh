<?php

declare(strict_types=1);

namespace Tests\Feature\Api\V1\Admin;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UsersTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A user activity test.
     *
     * @return void
     */

    /** @test */
    public function record_user_last_activity()
    {
        $user = User::factory()->create();

        Carbon::setTestNow(Carbon::now()->startOfMinute());

        $this->assertEquals($user->last_active_at, null);

        Sanctum::actingAs(
            $user,
        );

        $this->getJson('api/v1/admin/tasks');

        $this->assertEquals($user->last_active_at, Carbon::now());

    }
}
