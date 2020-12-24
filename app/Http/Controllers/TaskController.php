<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\Task;
use App\User;

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
      $project->addTask(request('body'));

      if(!$project->scores()->where('message','Task Added')->exists()){
        $project->addScore('Task Added',10);
      }
    }


    public function projectupdate(Project $project,Task $task){
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
