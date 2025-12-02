<?php

declare(strict_types=1);

namespace App\Repository\Admin;

use App\Models\Task;

class TaskRepository
{
    public function getTasksWithFilter($request, $perPage)
    {
        return Task::with('project', 'status', 'assignee', 'owner')
            ->withTrashed()
            ->latest('created_at')
            ->when($request->string('filter')->trim()->lower()->exactly('active'), fn ($query) => $query->whereNull('deleted_at'))
            ->when($request->string('filter')->trim()->lower()->exactly('trashed'), fn ($query) => $query->whereNotNull('deleted_at'))
            ->when($request->search, function ($query) use ($request): void {
                $query->whereHas('project', function ($subQuery) use ($request): void {
                    $subQuery->where('name', 'like', '%'.$request->search.'%');
                });
            })
            ->paginate($perPage);

    }
}
