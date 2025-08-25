<?php
namespace App\Repository;

use App\Models\Task;
use App\Http\Requests\Api\V1\UserTasksRequest;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;

class UserTasksDataRepository
{
    public function getTasks(int $userId, UserTasksRequest $request): Collection
    {
        $validated = $request->validated();

        $query = Task::query();
        
        // Apply user context filters with explicit logic
        $this->applyUserContextFilters($query, $userId, $validated);
        
        return $query
            ->when($validated['completed'] ?? false, fn($q) => $q->completed())
            ->when($validated['overdue'] ?? false, fn($q) => $q->overdue())
            ->when($validated['remaining'] ?? false, fn($q) => $q->remaining())
            ->with([
                'project' => fn($q) => $q->withTrashed(),
                'status', 
                'assignee' => fn($q) => $q->with('roles:id,name')
            ])
            ->get();
    }

    protected function applyUserContextFilters(Builder $query, int $userId, array $validated): void
    {
        $created = $validated['user_created'] ?? false;
        $assigned = $validated['task_assigned'] ?? false;

        if ($created && $assigned) {
            // Both filters: tasks created by user OR assigned to user
            $query->where(function ($q) use ($userId) {
                $q->where('user_id', $userId)
                  ->orWhereHas('assignee', fn($sub) => $sub->where('users.id', $userId));
            });
        } elseif ($created) {
            $query->where('user_id', $userId);
        } elseif ($assigned) {
            $query->whereHas('assignee', fn($sub) => $sub->where('users.id', $userId));
        }
    }

    public function appliedFilters(UserTasksRequest $request): array
    {
        $labels = [
            'user_created' => 'Filter by Created',
            'task_assigned' => 'Filter by Assigned',
            'completed' => 'Filter by Completed',
            'overdue' => 'Filter by Overdue',
            'remaining' => 'Filter by Remaining',
        ];

        $enabled = collect($request->validated())
            ->filter(fn ($v) => filter_var($v, FILTER_VALIDATE_BOOLEAN))
            ->keys();

        return collect($labels)->only($enabled)->values()->all();
    }
}