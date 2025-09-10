<?php

// Example of how to update your controller to use the optimized ProjectInsightService

namespace App\Http\Controllers\Api\V1;

use App\Services\Api\V1\ProjectInsightService;
use Illuminate\Http\Request;

class ProjectInsightController extends Controller
{
    public function __construct(
        private ProjectInsightService $projectInsightService
    ) {}

    public function getProjectInsights(Request $request, int $projectId)
    {
        // Get sections from request parameter, default to 'all' if not provided
        $sections = $request->input('sections', ['all']);
        
        // Ensure sections is always an array
        if (is_string($sections)) {
            $sections = explode(',', $sections);
        }

        // Get insights with optimized single query
        $insights = $this->projectInsightService->getInsights($projectId, $sections);

        return response()->json([
            'success' => true,
            'data' => $insights,
            'meta' => [
                'project_id' => $projectId,
                'sections_loaded' => $sections,
                'total_insights' => count($insights)
            ]
        ]);
    }
}

/* 
Usage examples:

1. Get all insights (default behavior):
   GET /api/v1/projects/123/insights

2. Get specific insights only:
   GET /api/v1/projects/123/insights?sections=health,completion,overdue

3. Get single insight:
   GET /api/v1/projects/123/insights?sections=health

Available sections:
- completion: Project completion rate
- health: Overall project health
- overdue: Overdue tasks status
- engagement: Team engagement levels
- risk: Upcoming risk assessment
- stage: Stage-based progress
- collaboration: Team collaboration score
- progress: Progress health metrics
- all: Include all insights (default)

Performance Benefits:
- Single database query instead of 15+ queries
- Section-based filtering for minimal data transfer
- Type-safe DTO for structured data
- Laravel best practices compliance
*/
