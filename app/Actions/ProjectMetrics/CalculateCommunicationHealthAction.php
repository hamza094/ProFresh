<?php

namespace App\Actions\ProjectMetrics;

use App\Models\Project;

class CalculateCommunicationHealthAction
{
    public function execute(Project $project): float
    {
        $recentConversationsCount = $project->recent_conversations_count ?? 0;
        return min(100, $recentConversationsCount * 10);
    }
}
