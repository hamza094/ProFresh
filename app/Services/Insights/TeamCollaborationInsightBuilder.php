<?php

namespace App\Services\Insights;

use App\Enums\InsightType;

final class TeamCollaborationInsightBuilder implements InsightBuilderInterface
{
    private const EXCELLENT_THRESHOLD = 85;
    private const GOOD_THRESHOLD = 65;
    private const WARNING_THRESHOLD = 40;
    private const LOW_PARTICIPATION_THRESHOLD = 0.3; // 30% participation rate

    public function build(mixed $input, array $context = []): array
    {
        if ($input === null || !is_numeric($input)) {
            return [
                'type' => InsightType::INFO->value,
                'title' => 'No Collaboration Data',
                'message' => 'No collaboration data available.',
                'data' => ['value' => null]
            ];
        }

        $score = (float) max(0, min(100, $input));
        $details = $context['details'] ?? [];
        $memberCount = (int) ($details['member_count'] ?? 0);
        $meetingCount = (int) ($details['meeting_count'] ?? 0);
        $participantCount = (int) ($details['participant_count'] ?? 0);
        
        // Calculate participation rate once and reuse
        $participationRate = $this->calculateParticipationRate($memberCount, $participantCount);

        return [
            'type' => $this->determineInsightType($score, $participationRate),
            'title' => $this->generateTitle($score),
            'message' => $this->generateMessage($score, $memberCount, $meetingCount, $participationRate),
            'data' => ['value' => $score]
        ];
    }

    private function calculateParticipationRate(int $memberCount, int $participantCount): float
    {
        return $memberCount > 0 ? $participantCount / $memberCount : 0.0;
    }

    private function determineInsightType(float $score, float $participationRate): string
    {
        return match (true) {
            $participationRate < self::LOW_PARTICIPATION_THRESHOLD => InsightType::CRITICAL->value,
            $score >= self::EXCELLENT_THRESHOLD => InsightType::SUCCESS->value,
            $score >= self::GOOD_THRESHOLD => InsightType::INFO->value,
            $score >= self::WARNING_THRESHOLD => InsightType::WARNING->value,
            default => InsightType::WARNING->value,
        };
    }

    private function generateTitle(float $score): string
    {
        return match (true) {
            $score >= self::EXCELLENT_THRESHOLD => 'Excellent Team Collaboration',
            $score >= self::GOOD_THRESHOLD => 'Good Team Collaboration',
            $score >= self::WARNING_THRESHOLD => 'Limited Team Collaboration', 
            default => 'Poor Team Collaboration',
        };
    }

    private function generateMessage(float $score, int $memberCount, int $meetingCount, float $participationRate): string
    {
        $participationPercent = (int) ($participationRate * 100);
        $participantCount = (int) ($memberCount * $participationRate);

        if ($participationRate < self::LOW_PARTICIPATION_THRESHOLD) {
            return sprintf(
                'Critical: Only %d%% participation (%d of %d members). Improve team engagement.',
                $participationPercent, $participantCount, $memberCount
            );
        }

        return sprintf(
            'Collaboration score: %.1f%% with %d%% team participation (%d of %d members).',
            $score, $participationPercent, $participantCount, $memberCount
        );
    }
}