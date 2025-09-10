<?php

return [
    'engagement' => [
        'thresholds' => ['high' => 21, 'low' => 10],
        'messages' => [
            'high' => [
                'title' => 'High Team Engagement',
                'message' => 'Team engagement is %.1f - highly engaged'
            ],
            'low' => [
                'title' => 'Low Team Engagement',
                'message' => 'Team engagement is %.1f - below optimal'
            ],
            'normal' => [
                'title' => 'Team Engagement',
                'message' => 'Team engagement is %.1f'
            ],
        ]
    ],
    
    'collaboration' => [
        'thresholds' => ['high' => 80, 'low' => 40],
        'messages' => [
            'high' => [
                'title' => 'Strong Collaboration',
                'message' => 'Collaboration score: %.0f%% - excellent teamwork'
            ],
            'low' => [
                'title' => 'Weak Collaboration',
                'message' => 'Collaboration score: %.0f%% - needs improvement'
            ],
            'normal' => [
                'title' => 'Collaboration Status',
                'message' => 'Collaboration score: %.0f%%'
            ],
        ]
    ],

    'progress' => [
        'messages' => [
            'title' => 'Progress Health',
            'message' => 'Progress health score is %.0f%%'
        ]
    ],

    'health' => [
        'excellent_threshold' => 90,
        'critical_threshold' => 40
    ],

    'overdue' => [
        'high_priority_threshold' => 3
    ]
];
