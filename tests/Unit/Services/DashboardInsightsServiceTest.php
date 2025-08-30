<?php

namespace Tests\Unit\Services;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Services\Api\V1\Dashboard\DashboardInsightsService;
use App\Repository\DashboardInsightsRepository;
use App\Models\User;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Support\Collection;

class DashboardInsightsServiceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_correct_kpis_for_user()
    {
        // Arrange
        $mockRepo = $this->createMock(DashboardInsightsRepository::class);
        $mockRepo->method('getUserProjects')->willReturn(collect([(object)['id'=>1], (object)['id'=>2]]));
        $mockRepo->method('getOverdueTasksCount')->willReturn(5);
        $mockRepo->method('getCriticalProjectsCount')->willReturn(1);
        $mockRepo->method('getTaskCompletionRate')->willReturn(80.0);

        $service = new DashboardInsightsService($mockRepo);

        // Act
        $kpis = $service->getKPIs(123);

        // Assert
        $this->assertEquals(2, $kpis['total_projects']['value']);
        $this->assertEquals(1, $kpis['critical_projects']['value']);
        $this->assertEquals(5, $kpis['overdue_tasks']['value']);
        $this->assertEquals(80.0, $kpis['completion_rate']['value']);
    }

    /** @test */
    public function it_returns_actionable_insights_for_various_scenarios()
    {
        // Arrange
        $mockRepo = $this->createMock(DashboardInsightsRepository::class);
        $mockRepo->method('getUserProjects')->willReturn(collect([(object)['id'=>1]]));
        $mockRepo->method('getOverdueTasksCount')->willReturn(12); // above critical threshold
        $mockRepo->method('getCriticalProjectsCount')->willReturn(2);

        $service = new DashboardInsightsService($mockRepo);

        // Act
        $insights = $service->getActionableInsights(123);

        // Assert
        $this->assertNotEmpty($insights);
        
        $this->assertTrue(collect($insights)->contains(function($item) {
            return $item['type'] === 'critical';
            return $item['title'] === 'High Overdue TaskCount';
            return $item['priority'] === 'high';
        }));

        $this->assertTrue(collect($insights)->contains(function($item) {
            return $item['type'] === 'warning';
            return $item['title'] === 'Project Needs Attention';
            return $item['priority'] === 'medium';
        }));
    }

    /** @test */
    public function it_returns_no_active_projects_insight()
    {
        // Arrange
        $mockRepo = $this->createMock(DashboardInsightsRepository::class);
        $mockRepo->method('getUserProjects')->willReturn(collect([]));
        $mockRepo->method('getOverdueTasksCount')->willReturn(0);
        $mockRepo->method('getCriticalProjectsCount')->willReturn(0);

        $service = new DashboardInsightsService($mockRepo);

        // Act
        $insights = $service->getActionableInsights(123);

        // Assert
        $this->assertNotEmpty($insights);
        $this->assertTrue(collect($insights)->contains(function($item) {
            return $item['type'] === 'info';
            return $item['title'] === 'No Active Projects';
            return $item['priority'] === 'medium';
        }));
    }

    /** @test */
    public function it_returns_portfolio_healthy_insight_when_no_issues()
    {
        // Arrange
        $mockRepo = $this->createMock(DashboardInsightsRepository::class);
        $mockRepo->method('getUserProjects')->willReturn(collect([(object)['id'=>1]]));
        $mockRepo->method('getOverdueTasksCount')->willReturn(0);
        $mockRepo->method('getCriticalProjectsCount')->willReturn(0);

        $service = new DashboardInsightsService($mockRepo);

        // Act
        $insights = $service->getActionableInsights(123);

        // Assert
        $this->assertNotEmpty($insights);
        $this->assertTrue(collect($insights)->contains(function($item) {
            return $item['type'] === 'success';
            return $item['title'] === 'Portfolio Healthy';
            return $item['priority'] === 'low';
        }));
    }

    /** @test */
    public function it_returns_warning_insight_for_some_overdue_tasks_below_critical()
    {
        // Arrange
        $mockRepo = $this->createMock(DashboardInsightsRepository::class);
        $mockRepo->method('getUserProjects')->willReturn(collect([(object)['id'=>1]]));
        $mockRepo->method('getOverdueTasksCount')->willReturn(5); // below critical threshold
        $mockRepo->method('getCriticalProjectsCount')->willReturn(0);

        $service = new DashboardInsightsService($mockRepo);

        // Act
        $insights = $service->getActionableInsights(123);

        // Assert
        $this->assertNotEmpty($insights);
        $this->assertTrue(collect($insights)->contains(function($item) {
            return $item['type'] === 'warning';
            return $item['title'] === 'Overdue Tasks Detected';
            return $item['priority'] === 'high';
        }));
    }

}
