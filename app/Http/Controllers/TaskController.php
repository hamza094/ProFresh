<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\Task;
use App\User;
use App\Notifications\ProjectTask;


class TaskController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');

  }

  public function projectindex(Project $project){
      return $project->tasks()->latest()->get();
  }

    public function projectstore(Project $project,Request $request){
      $this->validate($request, [
        'body'=>'required',
    ]);
    $this->authorize('access',$project);

      $project->addTask(request('body'));

      foreach($project->members->where('pivot.active',1) as $member){
        if(auth()->user()->id != $member->id){
          $member->notify(new ProjectTask($project));
        }
      }

      if(auth()->user()->id != $project->owner->id){
      $project->owner->notify(new ProjectTask($project));
     }

      if(!$project->scores()->where('message','Task Added')->exists()){
        $project->addScore('Task Added',10);
      }
    }


    public function projectupdate(Project $project,Task $task){
      $this->authorize('access',$project);

      $task->update([
            'body'=>request('body')]);

         if(request('completed')){
            $task->complete();
            }else{
              $task->incomplete();
            }
    }

      public function projectdelete(Project $project,Task $task){
        $task->delete();
        $task->activity()->delete();
        $project->recordActivity('deleted_task',$task->body);
      }

}
