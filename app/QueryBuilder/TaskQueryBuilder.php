<?php

namespace App\QueryBuilder;

use Illuminate\Database\Eloquent\Builder;
use App\Enums\TaskStatus as TaskStatusEnum;

/**
 * @extends Builder<\App\Models\Task>
 * @method $this onlyTrashed()
 */
class TaskQueryBuilder extends Builder
{
    /**
     * Filter completed tasks
     */
    public function completed(): self
    {
        return $this->where('status_id', TaskStatusEnum::COMPLETED);
    }

    /**
     * Filter remaining tasks (not completed and either no due date or due in future)
     */
    public function remaining(): self
    {
        return $this->where('status_id', '!=', TaskStatusEnum::COMPLETED)
                    ->where(function ($q) {
                        $q->whereNull('due_at')
                          ->orWhere('due_at', '>=', now());
                    });
    }

    /**
     * Filter overdue tasks (past due date and not completed)
     */
    public function overdue(): self
    {
        return $this->whereNotNull('due_at')
                    ->where('due_at', '<', now())
                    ->where('status_id', '!=', TaskStatusEnum::COMPLETED);
    }

    /**
     * Filter tasks due soon (within specified hours, default 48)
     */
    public function dueSoon(int $hours = 48): self
    {
        return $this->whereNotNull('due_at')
                    ->where('due_at', '>', now())
                    ->where('due_at', '<=', now()->addHours($hours))
                    ->where('status_id', '!=', TaskStatusEnum::COMPLETED);
    }


    public function active(): self
    {
        return $this->whereNull('deleted_at')->with('status');
    }

    /**
     * Filter tasks due for notifications
     */
    public function dueForNotifications(): self
    {
        return $this->whereNotNull(['notified', 'due_at'])
                    ->where('due_at', '>=', now())
                    ->where('notify_sent', false);
    }

    /**
     * Filter archived tasks
     */
    public function archived(): self
    {
        return $this->onlyTrashed()->with('status');
    }


}
