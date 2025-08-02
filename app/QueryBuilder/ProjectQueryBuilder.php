<?php

namespace App\QueryBuilder;

use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class ProjectQueryBuilder extends Builder
{
    /**
     * Search projects by name
     */
    public function search(string $search): self
    {
        return $this->where('name', 'like', "%{$search}%");
    }

    /**
     * Sort projects by different criteria
     */
    public function sortBy(string $sortBy = 'latest'): self
    {
        return match ($sortBy) {
            'oldest' => $this->orderBy('created_at', 'asc'),
            'name' => $this->orderBy('name', 'asc'),
            default => $this->orderBy('created_at', 'desc'),
        };
    }


    /**
     * Filter trashed projects
     */
    public function trashed(): self
    {
        return $this->onlyTrashed();
    }

    /**
     * Filter projects past abandoned limit
     */
    public function pastAbandonedLimit(): self
    {
        $abandonedLimit = config('app.project.abandonedLimit');

        return $this->where('deleted_at', '<', Carbon::now()->subDays($abandonedLimit));
    }

} 