<?php

namespace Tests\Feature\Api\V1\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use App\Traits\ProjectSetup;
use Laravel\Sanctum\Sanctum;
use Carbon\Carbon;
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
        $user=User::factory()->create();

        Carbon::setTestNow(Carbon::now()->startOfMinute());

        $this->assertEquals($user->last_active_at,null);

        Sanctum::actingAs(
          $user,
        );

        $this->getJson('api/v1/admin/tasks');

        $this->assertEquals($user->last_active_at,Carbon::now());

    }
}
