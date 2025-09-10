<?php

return [
    'kpi' => [
        // Optional: thresholds for completion rate status mapping (not fully used yet)
        'completion_rate_status' => [
            'excellent' => 80,
            'good' => 60,
            'warning' => 40,
        ],
    ],

    'insights' => [
        'overdue_tasks' => [
            // When total overdue tasks across projects exceed this, raise a critical insight
            'critical_threshold' => 10,
        ],
        'critical_project' => [
            // A project is considered critical if overdue tasks exceed this number
            'overdue_threshold' => 3,
        ],
    ],

    // Status thresholds used by service status helpers
    'statuses' => [
        'overdue' => [
            // 0 => good, <= warning_max => warning, else critical
            'warning_max' => 3,
        ],
        'critical_projects' => [
            // 0 => good, <= warning_max => warning, else critical
            'warning_max' => 2,
        ],
    ],

    'labels' => [
        'kpis' => [
            'total_projects' => 'Active Projects',
            'critical_projects' => 'Projects Need Attention',
            'overdue_tasks' => 'Total Overdue Tasks',
            'completion_rate' => 'Overall Completion Rate',
        ],
        'insights' => [
            'high_overdue_title' => 'High Overdue Task Count',
            'overdue_detected_title' => 'Overdue Tasks Detected',
            'projects_need_attention_title' => 'Projects Need Attention',
            'no_active_title' => 'No Active Projects',
            'portfolio_healthy_title' => 'Portfolio Healthy',
        ],
    ],

    // Project-specific KPI and insight configurations
    'project' => [
        'kpi' => [
            'health_status' => [
                'excellent' => 80,
                'good' => 60,
                'warning' => 40,
            ],
            'completion_rate_status' => [
                'excellent' => 90,
                'good' => 70,
                'warning' => 40,
            ],
        ],
        'statuses' => [
            'overdue' => [
                'warning_max' => 2,
            ],
            'engagement' => [
                'hot_threshold' => 21,
                'warm_threshold' => 15,
            ],
            'upcoming_risk' => [
                'warning_max' => 2,
            ],
        ],
        'insights' => [
            'health' => [
                'excellent_threshold' => 90,
                'critical_threshold' => 40,
            ],
            'overdue' => [
                'high_priority_threshold' => 3,
            ],
            'engagement' => [
                'high_threshold' => 21,
                'low_threshold' => 10,
            ],
        ],
        'labels' => [
            'kpis' => [
                'health' => 'Project Health',
                'completion_rate' => 'Completion Rate',
                'overdue_count' => 'Overdue Tasks',
                'team_engagement' => 'Team Engagement',
                'upcoming_risk' => 'Upcoming Risk',
                'communication_rate' => 'Communication Activity',
                'stage_progress' => 'Stage Progress',
            ],
        ],
    ],
];
