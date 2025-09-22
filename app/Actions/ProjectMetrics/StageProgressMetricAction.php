<?php

namespace App\Actions\ProjectMetrics;

use App\Models\Project;
use App\Enums\ProjectStage;

class StageProgressMetricAction
{
    public function execute(Project $project): array
    {
        $stageEnum = ProjectStage::tryFrom($project->stage_id);

        return [
            'percentage' => $stageEnum?->progress() ?? 0,
            'current_stage' => $stageEnum?->label() ?? 'Unknown',
            'status' => $stageEnum?->status() ?? 'unknown',
            'stage_id' => $project->stage_id,
        ];
    }
}
