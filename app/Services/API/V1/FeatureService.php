<?php

namespace App\Services\Api\V1;

use App\Models\Project;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProjectsExport;
use Illuminate\Support\Facades\Redis;
use App\Helpers\ProjectHelper;
use F9Web\ApiResponseHelpers;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use App\Enums\StageStatus;
use App\Models\Stage;
use Carbon\Carbon;

class FeatureService
{
    use ApiResponseHelpers;

    public function updateStageStatus($project, array $data)
    {
        DB::transaction(function () use ($project, $data) {

            $project->stage()->associate($data['stage']);

            $project->update([
            'postponed_reason' => $this->getPostponedReason($project, $data),
            'stage_updated_at' => now(),
    ]);

        });

        return $project;
    }

    private function getPostponedReason($project, array $data): ?string
    {
        return ($project->stage->name === StageStatus::Postponed->value && !empty($data['postponed_reason']))
            ? $data['postponed_reason']
            : null;
    }

    public function excelExport($project)
    {
        return  (new ProjectsExport($project))->download("Project $project->name.xlsx");

        /*  return $this->respondWithSuccess([
         'message'=>$project->name . " file exported successfully",
   ]);*/

        //self::recordActivity($project,'export_project','default');
    }

    public function recordActivity($project, $activity, $info)
    {
        $project->recordActivity($activity, $info);
    }

}
