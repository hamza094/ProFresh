<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Lead;
use App\Task;
use App\User;

class TaskController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }

  public function leadindex(Lead $lead){
      return $lead->tasks()->latest()->get();
  }

    public function leadstore(Lead $lead,Request $request){
      $this->validate($request, [
        'body'=>'required',
    ]);

      $lead->addTask(request('body'));
    }


    public function leadupdate(Lead $lead,Task $task){
      $task->update([
            'body'=>request('body')]);

         if(request('completed')){
            $task->complete();
            }else{
              $task->incomplete();
            }
    }

      public function leaddelete(Lead $lead,Task $task){
        $task->delete();
      }

}
