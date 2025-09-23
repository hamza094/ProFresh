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
     * Get project insights.
     * Handles both /projects/{project}/insights and /projects/{project}/insights/{section}
     *
     * @param ProjectInsightsRequest $request
     * @param Project $project
     * @return ProjectInsightsResource
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
