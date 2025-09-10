<?php

namespace App\Services\Insights;

class ProgressInsightBuilder
{
    /**
     * Build progress insight based on project progress score
     *
     * @param float|null $progressScore
     * @return array
     */
    public function build(?float $progressScore): array
    {
        if ($progressScore === null) {
            return [
                'type' => 'info',
                'title' => 'Progress Information',
                'message' => 'Progress data is not available for this project.',
                'data' => ['value' => 0]
            ];
        }

        return [
            'type' => $this->getProgressType($progressScore),
            'title' => config('insights.progress.messages.title', 'Project Progress'),
            'message' => sprintf(
                config('insights.progress.messages.message', 'Project progress is at %.1f%%'),
                $progressScore
            ),
            'data' => [
                'value' => $progressScore,
                'percentage' => $progressScore,
                'status' => $this->getProgressStatus($progressScore)
            ]
        ];
    }

    /**
     * Determine insight type based on progress score
     *
     * @param float $progressScore
     * @return string
     */
    private function getProgressType(float $progressScore): string
    {
        return match(true) {
            $progressScore >= 80 => 'success',
            $progressScore >= 60 => 'info',
            $progressScore >= 30 => 'warning',
            default => 'danger'
        };
    }

    /**
     * Get progress status description
     *
     * @param float $progressScore
     * @return string
     */
    private function getProgressStatus(float $progressScore): string
    {
        return match(true) {
            $progressScore >= 90 => 'Excellent',
            $progressScore >= 75 => 'Good',
            $progressScore >= 50 => 'Fair',
            $progressScore >= 25 => 'Poor',
            default => 'Critical'
        };
    }
}
