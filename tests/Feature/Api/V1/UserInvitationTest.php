<?php

namespace Tests\Feature\Api\V1;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Traits\ProjectSetup;
use App\Models\project;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserInvitationTest extends TestCase
{
    use RefreshDatabase,ProjectSetup;

     /** @test */
    public function it_returns_pending_project_invitations_for_authenticated_user()
    {
        // Create a project and attach as pending invitation
        $project = Project::factory()->create();

        $project->members()->attach($this->user->id, ['active' => false, 'created_at' => now(), 'updated_at' => now()]);

        $response = $this->getJson('/api/v1/me/invitations');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'invitations' => [
                         ['id', 'name', 'status', 'slug', 'invitation_sent_at', 'user', 'created_at', 'path']
                     ]
                 ]);

        $this->assertEquals($project->id, $response->json('invitations.0.id'));
    }

    /** @test */
    public function it_returns_empty_array_and_message_if_no_pending_invitations()
    {

        $response = $this->getJson('/api/v1/me/invitations');

        $response->assertStatus(200)
                 ->assertJson([
                     'invitations' => [],
                     'message' => 'No pending invitations found.'
                 ]);
    }
}
