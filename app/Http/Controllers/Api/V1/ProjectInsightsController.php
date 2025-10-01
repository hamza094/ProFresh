<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\ProjectInsightsRequest;
use App\Services\Api\V1\ProjectInsightService;
use App\Models\Project;
use App\Http\Resources\Api\V1\ProjectInsightsResource;

class ProjectInsightsController extends Controller
{
    public function __construct(
        private ProjectInsightService $insightService
    ) {}

    /**
     * Get actionable insights for a project.
     *
     * What this endpoint does:
     * - Aggregates calculated insights for the given project across one or more sections
     *   (health, task-health, collaboration, risk, stage).
     * - You can filter which sections are returned using the `sections[]` query parameter.
     * - If `sections[]` is omitted, all supported sections are returned.
     *
     */
    public function index(ProjectInsightsRequest $request, Project $project): ProjectInsightsResource
    {
        $sections = $request->getSections();

        $insights = $this->insightService->getInsights($project, $sections);

        return new ProjectInsightsResource([
            'project' => $project,
            'insights' => $insights,
            'sections' => $sections,
        ]);
    }
}
