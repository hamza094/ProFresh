<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\Insights\HealthInsightBuilder;
use App\Services\Insights\TaskHealthInsightBuilder;
use App\Services\Insights\TeamCollaborationInsightBuilder;
use App\Services\Insights\RiskInsightBuilder;
use App\Services\Insights\StageInsightBuilder;


class ProjectInsightResponseServiceTest extends TestCase
{

    /** @test */
    public function health_builder_handles_null_and_numeric(): void
    {
        $builder = new HealthInsightBuilder();

        $null = $builder->build(null);
        $this->assertSame('No Health Data', $null['title']);
        $this->assertNull($null['data']['value']);

        $ok = $builder->build(86.7);
        $this->assertStringContainsString('Project Health', $ok['title']);
        $this->assertIsNumeric($ok['data']['value']);
        $this->assertGreaterThanOrEqual(0, $ok['data']['value']);
        $this->assertLessThanOrEqual(100, $ok['data']['value']);
    }

    /** @test */
    public function task_health_builder_uses_summary_for_type_and_message(): void
    {
        $builder = new TaskHealthInsightBuilder();

        $noData = $builder->build(null);
        $this->assertSame('No Task Data', $noData['title']);
        $this->assertNull($noData['data']['value']);

        $good = $builder->build(75, ['summary' => ['completion_rate' => 80, 'overdue_rate' => 5, 'abandonment_rate' => 2]]);
    $this->assertStringContainsString('Good Task Health', $good['title']);
    $this->assertSame('info', $good['type']);

    $criticalOverdue = $builder->build(60, ['summary' => ['completion_rate' => 75, 'overdue_rate' => 30, 'abandonment_rate' => 2]]);
    $this->assertSame('critical', $criticalOverdue['type']);
    $this->assertStringContainsString('tasks are overdue', strtolower($criticalOverdue['message']));

    $criticalAbandon = $builder->build(60, ['summary' => ['completion_rate' => 85, 'overdue_rate' => 5, 'abandonment_rate' => 20]]);
    $this->assertSame('critical', $criticalAbandon['type']);
    $this->assertStringContainsString('abandon', strtolower($criticalAbandon['message']));
    }

    /** @test */
    public function collaboration_builder_prioritizes_low_participation(): void
    {
        $builder = new TeamCollaborationInsightBuilder();

        $noData = $builder->build(null);
        $this->assertSame('No Collaboration Data', $noData['title']);

        $ok = $builder->build(70, ['details' => ['member_count' => 10, 'meeting_count' => 3, 'participant_count' => 8]]);
    $this->assertStringContainsString('Good Team Collaboration', $ok['title']);
        $this->assertIsNumeric($ok['data']['value']);
    $this->assertStringContainsString('80% team participation', strtolower($ok['message']));
    $this->assertSame('info', $ok['type']);

        // Low participation should force critical regardless of score
        $low = $builder->build(60, ['details' => ['member_count' => 5, 'meeting_count' => 1, 'participant_count' => 2]]);
    $this->assertStringContainsString('Limited Team Collaboration', $low['title']);
        $this->assertSame('warning', $low['type']);
    $this->assertStringContainsString('participation', strtolower($low['message']));
    }

    /** @test */
    public function risk_builder_uses_counts_and_score(): void
    {
        $builder = new RiskInsightBuilder();

        $no = $builder->build(['wrong' => 1]);
        $this->assertSame('No Risk Data', $no['title']);

        $zero = $builder->build(['score' => 0, 'at_risk_count' => 0, 'due_soon_count' => 0]);
        $this->assertSame('No Risk Detected', $zero['title']);
        $this->assertStringContainsString('No upcoming', $zero['message']);
    $this->assertSame('success', $zero['type']);

        $low = $builder->build(['score' => 10, 'at_risk_count' => 1, 'due_soon_count' => 5]);
        $this->assertSame('Low Risk', $low['title']);
    $this->assertSame('info', $low['type']);

        $high = $builder->build(['score' => 85, 'at_risk_count' => 5, 'due_soon_count' => 7]);
        $this->assertSame('High Risk Alert', $high['title']);
        $this->assertSame('critical', $high['type']);
    }

    /** @test */
    public function stage_builder_uses_percentage_status_and_stage(): void
    {
        $builder = new StageInsightBuilder();

        $no = $builder->build(['foo' => 'bar']);
        $this->assertSame('No Stage Data', $no['title']);

        $dev = $builder->build([
            'percentage' => 45,
            'current_stage' => 'Development',
            'status' => 'in_progress',
            'stage_id' => 3,
        ]);
        $this->assertSame('Active Development', $dev['title']);
        $this->assertIsNumeric($dev['data']['value']);
        $this->assertSame('Development', $dev['data']['stage']);
        $this->assertSame('info', $dev['type']);

        $completed = $builder->build([
            'percentage' => 100,
            'current_stage' => 'Completed',
            'status' => 'completed',
            'stage_id' => 6,
        ]);
        $this->assertSame('Project Completed', $completed['title']);
        $this->assertSame('success', $completed['type']);

        $postponed = $builder->build([
            'percentage' => 10,
            'current_stage' => 'Planning',
            'status' => 'postponed',
            'stage_id' => 7,
        ]);
        $this->assertSame('Project Postponed', $postponed['title']);
        $this->assertSame('warning', $postponed['type']);
    }
}
