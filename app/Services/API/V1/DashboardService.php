<?php

namespace App\Services\Api\V1;

use App\Http\Resources\Api\V1\ProjectsResource;
use Illuminate\Http\Request;
use App\Repository\DashBoardRepository;
use App\Models\User;
use Illuminate\Support\Collection;
use Auth;
use App\Models\Project;

class DashboardService
{
    protected DashBoardRepository $dashboardRepository;

    public function __construct(DashBoardRepository $dashboardRepository)
    {
        $this->dashboardRepository = $dashboardRepository;
    }

    public function getUserProjects($request)
    {
        $user = Auth::user();
        return $this->filterProjects($user, $request);
    }

    public function getDashboardProjects()
    {
        $user = Auth::user();
        return $user->projects()
            ->with('stage')
            ->latest()
            ->take(3)
            ->get();
    }

    private function filterProjects(User $user, $request): Collection
    {
        $filters = $this->getFilters($request);
        $query = $filters['member'] 
            ? $user->members(true)
            : $user->projects();
        return $query
            ->with(['stage', 'user'])
            ->when($filters['abandoned'], fn($query) => $query->trashed())
            ->when($filters['search'], fn($query) => $query->search($filters['search']))
            ->sortBy($filters['sort'])
            ->get();
    }

    private function getFilters($request): array
    {
        return [
            'search' => $request->validated('search'),
            'sort' => $request->validated('sort', 'latest'),
            'member' => $request->validated('member', false),
            'abandoned' => $request->validated('abandoned', false),
        ];
    }


}