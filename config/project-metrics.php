<?php

return [
    'health' => [
        'weights' => [
          'tasks' => 0.3,
          'communication' => 0.2, 
          'collaboration' => 0.2,
          'stage' => 0.2,
          'activity' => 0.1,
        ],
        'task_health' => [
            'overdue_penalty_multiplier' => 40,
            'abandonment_penalty_multiplier' => 30,
        ],
        'collaboration' => [
            // Component weights (should sum to 100)
            'weights' => [
                'member_base' => 40,      // Base score from team size
                'meeting_activity' => 30,  // Recent meeting activity  
                'participation' => 30,     // Member participation rate
            ],
            
            // Component maximums
            'caps' => [
                'member_max_score' => 40,
                'meeting_max_score' => 30,
                'participation_max_score' => 30,
            ],
            
            // Scoring parameters
            'member_score_per_person' => 4,  // 4 points per member (max 10 members = 40)
            'meeting_score_per_meeting' => 10, // 10 points per meeting (max 3 = 30)
            
            // Thresholds for insights
            'thresholds' => [
                'excellent' => 85,
                'good' => 70,
                'warning' => 50,
                'critical' => 30,
            ],

        ],
    ],
    
    'time_periods' => [
        'recent_activity_days' => 7,
        'meeting_lookback_days' => 14,
        'risk_assessment_hours' => 48,
        'task_inactivity_days' => 5,
    ],
    
    'engagement' => [
        'task_multiplier' => 2,
        'conversation_multiplier' => 1.5,
        'meeting_multiplier' => 5,
        'member_multiplier' => 3,
    ],
    
    'progress' => [
        'activity_count_for_full' => 15, // number of recent activities that count as 100%
    ],
];
