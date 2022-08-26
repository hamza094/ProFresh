<?php
namespace App\Repository;

use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;

  /**
   * Filter project activities.
   *
   * @param  $activities
   */

class ProjectRepository
{
  public function filterProjectActivity($activities)
  {
    $this->filterActivityByAuthUser($activities);

    $this->filterActivityByTask($activities);

    $this->filterActivityByProjectSpecified($activities);
  }

   /**
    * Filter activities by signIn user.
    *
    * @param  $activities
    */
    protected function filterActivityByAuthUser($activities)
    {
      return  $activities->when(request('mine'), function ($q) {
      $user = User::where('id', request('mine'))->firstOrFail();
      return $q->where('user_id', $user->id);
    });
    }

    /**
    * Filter activities by project related task.
    *
    * @param  $activities
    */
    protected function filterActivityByTask($activities)
    {
      return  $activities->when(request('task'), function ($q) {
      return $q->where('description', 'LIKE', '%'.'_task'.'%');
    });
    }

    /**
    * Filter activities by specified to project.
    *
    * @param  $activities
    */
    protected function filterActivityByProjectSpecified($activities)
    {
      return  $activities->when(request('related'), function ($q) {
      return $q->where('description', 'LIKE', '%'.'_project'.'%');
    });
    }
}

?>
