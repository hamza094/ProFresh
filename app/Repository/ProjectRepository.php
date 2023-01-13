<?php
namespace App\Repository;

use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

  /**
   * Filter project activities.
   *
   * @param  $activities
   */

class ProjectRepository
{
  public function filterProjectByActivity(Collection $activities)
  {
    $filters = [
      'specifics' => 'filterActivityByProjectSpecified',
      'tasks' => 'filterActivityByTasks',
      'members' => 'filterActivityByMembers',
      'mine' => 'filterActivityByAuthUser',
    ];

    foreach ($filters as $key => $filter) {
        if (request()->has($key)) {
            return $this->$filter($activities);
        }
    }
  }

   /**
    * Filter activities by auth user.
    *
    * @param  $activities
    */
    protected function filterActivityByAuthUser($activities)
    { 
      return $activities->where('user_id',request('mine'));
    }

    /**
    * Filter activities by project related task.
    *
    * @param  $activities
    */
    protected function filterActivityByTasks($activities)
    {
      return $activities->filter(fn($activity) => strpos($activity['description'], '_task') !== false);
    }

    /**
    * Filter activities by specified to project.
    *
    * @param  $activities
    */
    protected function filterActivityByProjectSpecified($activities)
    {
      return $activities->filter(fn($activity) => strpos($activity['description'], '_project') !== false);
    }

    /**
    * Filter activities by project members.
    *
    * @param  $activities
    */
    protected function filterActivityByMembers($activities)
    {
      return $activities->filter(fn($activity) => strpos($activity['description'], '_member') !== false);
    }
}

?>
