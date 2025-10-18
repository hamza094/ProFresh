<?php

namespace App\Services\Api\V1;

use App\Http\Requests\Api\V1\DashboardProjectRequest;
use App\Repository\DashBoardRepository;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Auth;

class DashboardService
{
    protected DashBoardRepository $dashboardRepository;

    public function __construct(DashBoardRepository $dashboardRepository)
    {
        $this->dashboardRepository = $dashboardRepository;
    }

    /**
    * @param DashboardProjectRequest $request
    * @return Collection<int, \App\Models\Project>|null
    */
    public function getUserProjects(DashboardProjectRequest $request): ?Collection
    {
        $user = Auth::user();
        if (! $user instanceof User) {
            return null;
        }

        return $this->filterProjects($user, $request);
    }

    /**
    * @return Collection<int, \App\Models\Project>
    */
    public function getDashboardProjects(): Collection
    {
        $user = Auth::user();
        if (! $user instanceof User) {
            return collect();
        }

        return $user->projects()
            ->with('stage')
            ->latest()
            ->take(3)
            ->get();
    }

    /**
    * @param User $user
    * @param DashboardProjectRequest $request
    * @return Collection<int,\App\Models\Project>
    */
    private function filterProjects(User $user, DashboardProjectRequest $request): Collection
    {
        $filters = $this->getFilters($request);
        $query = $filters['member'] 
            ? $user->members(true)
            : $user->projects();
        $results = $query
            ->with(['stage', 'user'])
            ->when($filters['abandoned'], fn($query) => $query->trashed())
            ->when($filters['search'], fn($query) => $query->search($filters['search']))
            ->sortBy($filters['sort'])
            ->get();

        /** @var Collection<int, \App\Models\Project> $results */
        return $results;
    }

    /**
     * @param DashboardProjectRequest $request
     * @return array<string,mixed>
     */
    private function getFilters(DashboardProjectRequest $request): array
    {
        return [
            'search' => $request->validated('search'),
            'sort' => $request->validated('sort', 'latest'),
            'member' => $request->validated('member', false),
            'abandoned' => $request->validated('abandoned', false),
        ];
    }


}