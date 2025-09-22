<?php

namespace App\Actions\ProjectMetrics;

use App\Models\Project;

class TeamCollaborationMetricAction
{
    private const DEFAULT_MEMBER_SCORE_PER_PERSON = 4;
    private const DEFAULT_MEETING_SCORE_PER_MEETING = 10;
    private const DEFAULT_MAX_MEMBER_SCORE = 40;
    private const DEFAULT_MAX_MEETING_SCORE = 30;
    private const DEFAULT_MAX_PARTICIPATION_SCORE = 30;

    public function execute(Project $project): float
    {
        $activeMembers = max(0, (int) ($project->active_members_count ?? 0));
        $recentMeetings = max(0, (int) ($project->recent_meetings_count ?? 0));
        $recentParticipants = max(0, (int) ($project->recent_participants_count ?? 0));
        
        if ($activeMembers === 0) {
            return 0.0;
        }
        
        $memberScore = $this->calculateMemberScore($activeMembers);
        $meetingScore = $this->calculateMeetingScore($recentMeetings);
        $participationScore = $this->calculateParticipationScore($recentParticipants, $activeMembers);
        
        $totalScore = $memberScore + $meetingScore + $participationScore;
        
        return round(min(100.0, max(0.0, $totalScore)), 1);
    }

    private function calculateMemberScore(int $memberCount): float
    {
        $maxScore = config('project-metrics.health.collaboration.caps.member_max_score', self::DEFAULT_MAX_MEMBER_SCORE);
        $scorePerMember = config('project-metrics.health.collaboration.member_score_per_person', self::DEFAULT_MEMBER_SCORE_PER_PERSON);
        
        return min($maxScore, $memberCount * $scorePerMember);
    }
    
    private function calculateMeetingScore(int $meetingCount): float
    {
        $maxScore = config('project-metrics.health.collaboration.caps.meeting_max_score', self::DEFAULT_MAX_MEETING_SCORE);
        $scorePerMeeting = config('project-metrics.health.collaboration.meeting_score_per_meeting', self::DEFAULT_MEETING_SCORE_PER_MEETING);
        
        return min($maxScore, $meetingCount * $scorePerMeeting);
    }
    
    private function calculateParticipationScore(int $participantCount, int $totalMembers): float
    {
        if ($totalMembers === 0) {
            return 0.0;
        }
        
        $maxScore = config('project-metrics.health.collaboration.caps.participation_max_score', self::DEFAULT_MAX_PARTICIPATION_SCORE);
        $participationRate = $participantCount / $totalMembers;
        
        return min($maxScore, $participationRate * $maxScore);
    }
}
