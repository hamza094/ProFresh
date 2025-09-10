<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\ProjectInsightsRequest;
use App\Services\Api\V1\ProjectInsightService;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\Api\V1\ProjectInsightsResource;

class ProjectInsightsController extends Controller
{
    public function __construct(
        private ProjectInsightService $insightService
    ) {}

    /**
     * Get project insights for authenticated user.
     * Handles both /projects/{project}/insights and /projects/{project}/insights/{section}
     *
     * @param ProjectInsightsRequest $request
     * @param Project $project
     * @return JsonResponse
     */
    public function index(ProjectInsightsRequest $request, Project $project): ProjectInsightsResource
    {
        $userId = $request->user()->id;
        $sections = $request->getSections();
        $singleSection = $request->route('section');

        $insights = $this->insightService->getInsights($project, $userId, $sections);

        return new ProjectInsightsResource([
            'project' => $project,
            'insights' => $insights,
            'sections' => $sections,
            'single_section' => $singleSection,
        ],200);
    }
}
