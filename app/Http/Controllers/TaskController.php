<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\Task;
use App\Notifications\ProjectTask;
use App\Http\Requests\TaskRequest;

class TaskController extends Controller
{
  
  /**
    * Show all project related tasks 
    *
    */
  public function index(Project $project)
  {
    return $project->tasks()->latest()->get();
  }

   /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\TaskRequest  $request
     */
    public function store(Project $project,TaskRequest $request)
    {
      $project->tasks()->create($request->validated());

      $this->sendNotification($project,new ProjectTask($project));

      $this->recordScore($project,'Task Added',10);
    }

    /**
     * Update the specified resource.
     *
     * @param  int  $project
     */
    public function update(Project $project,Task $task,TaskRequest $request)
    {
       $task->update($request->validated());

         if(request('completed')){
            $task->complete();
            }else{
              $task->incomplete();
            }
    }
    
    /**
     * Delete the specified resource from database.
     *
     * @param  int  $project
     */
      public function destroy(Project $project,Task $task)
      {
        $task->delete();

        $task->activity()->delete();

        $project->recordActivity('deleted_task',$task->body);
      }

}
