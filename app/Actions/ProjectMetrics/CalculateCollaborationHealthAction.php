<?php

namespace App\Actions\ProjectMetrics;

use App\Models\Project;

class CalculateCollaborationHealthAction
{
    public function execute(Project $project): float
    {
        $activeMembersCount = $project->active_members_count ?? 0;
        $recentMeetingsCount = $project->recent_meetings_count ?? 0;
        
        if ($activeMembersCount === 0) return 0;
        
        $config = config('project-metrics.health.collaboration');
        $timePeriods = config('project-metrics.time_periods');
        
        // Get member participation rate with null safety
        $participantCount = $project->activities()
            ->where('created_at', '>=', now()->subDays($timePeriods['recent_activity_days']))
            ->distinct('user_id')
            ->count();
        
        $participationRate = ($participantCount / $activeMembersCount) * $config['participation_score_multiplier'];
        
        return min(100, ($activeMembersCount * $config['member_score_multiplier']) + 
                       ($recentMeetingsCount * $config['meeting_score_multiplier']) + 
                       $participationRate);
    }
}
