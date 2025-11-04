<?php

declare(strict_types=1);

return [
    // Time windows and thresholds used by insights repository
    'time_periods' => [
        'recent_activity_days' => 30,
        'collaboration_activity_days' => 30,
        'meeting_lookback_days' => 14,
        'conversation_lookback_days' => 14,
        'risk_assessment_hours' => 72,
        'task_inactivity_days' => 5,
    ],

    // Which count buckets are needed for each section
    'section_count_mappings' => [
        'health' => ['tasks', 'communication', 'collaboration', 'activity'],
        'task-health' => ['tasks'],
        'collaboration' => ['collaboration'],
        'risk' => ['risk'],
        'stage' => [],
    ],
];
