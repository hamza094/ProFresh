<?php
namespace App\Repository;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Models\Project;
use App\Models\Task;
use App\Models\Stage;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\DB;

class DashBoardRepository
{
    public function fetchData()
    {
        $userId = Auth::id();

   return Project::selectRaw(
    '(SELECT COUNT(*) FROM projects WHERE user_id = ? AND deleted_at IS NULL) AS active_projects,

    (SELECT COUNT(DISTINCT id) FROM projects WHERE user_id = ? AND deleted_at IS NOT NULL) AS trashed_projects,

    SUM(CASE WHEN project_members.user_id = ? AND project_members.active = 1 THEN 1 ELSE 0 END) AS active_invited_projects,

    (SELECT COUNT(*) FROM projects WHERE user_id = ? AND deleted_at IS NULL) +

    (SELECT COUNT(DISTINCT id) FROM projects WHERE user_id = ? AND deleted_at IS NOT NULL) +

    SUM(CASE WHEN project_members.user_id = ? AND project_members.active = 1 THEN 1 ELSE 0 END) AS total_projects

', [$userId, $userId, $userId, $userId, $userId, $userId])

->leftJoin('project_members', 'projects.id', '=', 'project_members.project_id')

->where(function($query) use ($userId) {
    $query->where('projects.user_id', $userId)
          ->orWhere('project_members.user_id', $userId);
    })
    ->first();
    }

 }

?>