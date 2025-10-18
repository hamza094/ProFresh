<?php

namespace Tests\Feature\Api\V1\ProjectDashboard;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Traits\ProjectSetup;

class UserKpiMetricesTest extends TestCase
{
    use RefreshDatabase, WithFaker, ProjectSetup;

    /** @test */
    public function it_returns_dashboard_kpis_and_insights_for_authenticated_user()
    {
        $response = $this->getJson(route('dashboard.insights'));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'kpis' => [
                'total_projects' => ['value', 'label', 'status'],
                'critical_projects' => ['value', 'label', 'status'],
                'overdue_tasks' => ['value', 'label', 'status'],
                'completion_rate' => ['value', 'label', 'status'],
            ],
            'insights',
        ]);

        $data = $response->json();
        $this->assertIsArray($data['kpis']);
        $this->assertIsArray($data['insights']);
    }
}
