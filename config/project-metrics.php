<?php

return [
    'health' => [
        'weights' => [
            'tasks' => 0.4,
            'communication' => 0.25,
            'collaboration' => 0.2,
            'progress' => 0.15,
        ],
        'task_health' => [
            'overdue_penalty_multiplier' => 40,
        ],
        'collaboration' => [
            'member_score_multiplier' => 10,
            'meeting_score_multiplier' => 15,
            'participation_score_multiplier' => 50,
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
        'stage_weight' => 0.6,
        'activity_multiplier' => 5,
        'activity_max_score' => 40,
    ],
];
