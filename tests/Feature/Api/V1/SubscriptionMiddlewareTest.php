<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use App\Models\Project;
use App\Models\TaskStatus;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SubscriptionMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function unsubscribed_user_can_not_access_some_features()
    {
        $status=TaskStatus::factory()->create();
        $user=User::factory()->create([
       'email'=>'johndoe@example.org',
       'password'=>Hash::make('testpassword')
   ]);

   Sanctum::actingAs(
       $user,
   );

   $project = Project::factory()->for($user)->create();

   $response=$this->withoutExceptionHandling()->postJson($project->path().'/tasks',
           ['title' => 'My Project Task']);
   
   $response->assertForbidden();

    }
}
