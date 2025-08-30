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
];
