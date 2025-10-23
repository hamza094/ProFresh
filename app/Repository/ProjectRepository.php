<?php

namespace App\Repository;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ProjectRepository
{
    /**
     * Filter project activities based on the request parameters.
     *
     * @param  Collection  $activities  The collection of activities to filter.
     * @return Collection The filtered collection of activities.
     */
    public function filterActivities(Collection $activities): Collection
    {
        $filters = [
            'specifics' => 'filterActivityByProjectSpecified',
            'tasks' => 'filterActivityByTasks',
            'members' => 'filterActivityByMembers',
            'mine' => 'filterActivityByAuthUser',
        ];

        $filter = request()->only(array_keys($filters));
        $filter = key($filter);

        if ($filter !== 0 && ($filter !== '' && $filter !== '0') && array_key_exists($filter, $filters)) {
            $method = $filters[$filter];
            $activities = $this->$method($activities);
        }

        return $activities;
    }

    /**
     * Filter activities by authenticated user.
     *
     * @param  Collection  $activities
     */
    protected function filterActivityByAuthUser($activities): Collection
    {
        return $activities->where('user_id', auth()->id());
    }

    /**
     * Filter activities by project-related tasks.
     *
     * @param  Collection  $activities
     */
    protected function filterActivityByTasks($activities): Collection
    {
        return $activities->filter(fn ($activity) => str_contains((string) $activity['description'], '_task'));
    }

    /**
     * Filter activities by project-specified.
     *
     * @param  Collection  $activities
     */
    protected function filterActivityByProjectSpecified($activities): Collection
    {
        return $activities->filter(fn ($activity) => str_contains((string) $activity['description'], '_project'));
    }

    /**
     * Filter activities by project-member releated.
     *
     * @param  Collection  $activities
     */
    protected function filterActivityByMembers($activities): Collection
    {
        $types = [
            'invitation_sent',
            'invitation_accepted',
            'member_removed',
        ];

        return $activities->filter(fn ($activity) => in_array($activity['description'], $types));

    }
}
