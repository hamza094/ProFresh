<?php

namespace App\Actions\ProjectMetrics;

use App\Models\Project;

class CalculateTeamEngagementAction
{
    public function execute(Project $project): float
    {
        $config = config('project-metrics.engagement');
        
        $recentTasksCount = $project->recent_tasks_count ?? 0;
        $recentConversationsCount = $project->recent_conversations_count ?? 0;
        $recentMeetingsCount = $project->recent_meetings_count ?? 0;
        $activeMembersCount = $project->active_members_count ?? 0;

        return ($recentTasksCount * $config['task_multiplier']) + 
               ($recentConversationsCount * $config['conversation_multiplier']) + 
               ($recentMeetingsCount * $config['meeting_multiplier']) + 
               ($activeMembersCount * $config['member_multiplier']);
    }
}
