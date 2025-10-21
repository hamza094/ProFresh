<?php

namespace App\Repository\Admin;

use Illuminate\Support\Facades\DB;

class DashboardRepository
{
    public function fetchDataForMonths($startDate, $endDate)
    {
        $projectsData = DB::table('projects')
            ->selectRaw('
         DATE_FORMAT(created_at, ?) as month,
         COUNT(*) as total_projects,
         SUM(CASE WHEN deleted_at IS NULL THEN 1 ELSE 0 END) AS active_projects,
         SUM(CASE WHEN deleted_at IS NOT NULL THEN 1 ELSE 0 END) AS trashed_projects
         ', ['%Y-%m'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $tasksData = DB::table('tasks')
            ->selectRaw('
        DATE_FORMAT(created_at, ?) as month,
        COUNT(*) as total_tasks,
        SUM(CASE WHEN deleted_at IS NULL THEN 1 ELSE 0 END) AS active_tasks,
        SUM(CASE WHEN deleted_at IS NOT NULL THEN 1 ELSE 0 END) AS trashed_tasks
    ', ['%Y-%m'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return compact('projectsData', 'tasksData');
    }
}
