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

    if(request()->has('specifics'))
    {
       return $this->filterActivityByProjectSpecified($activities);
    }

    if(request()->has('tasks'))
    {
       return $this->filterActivityByTasks($activities);
    }

    if(request()->has('members'))
    {
        return $this->filterActivityByMembers($activities);
    }

     if(request()->has('mine'))
    {
        return  $this->filterActivityByAuthUser($activities);
    }

  }

   /**
    * Filter activities by auth user.
    *
    * @param  $activities
    */
    protected function filterActivityByAuthUser($activities)
    {
      $user = User::where('id', request('mine'))->firstOrFail();
      
      return $activities->where('user_id',$user->id);
    }

    /**
    * Filter activities by project related task.
    *
    * @param  $activities
    */
    protected function filterActivityByTasks($activities)
    {
      return $activities->filter(function ($query){
        return false !== stripos($query['description'], '_task');
      });
    }

    /**
    * Filter activities by specified to project.
    *
    * @param  $activities
    */
    protected function filterActivityByProjectSpecified($activities)
    {
      return $activities->filter(function ($query){
        return false !== stripos($query['description'], '_project');
      });
    }

    /**
    * Filter activities by project members.
    *
    * @param  $activities
    */
    protected function filterActivityByMembers($activities)
    {
      return $activities->filter(function ($query){
        return false !== stripos($query['description'], '_member');
      });
    }
}

?>
