<?php

namespace App\Http\Controllers\Api;

use App\Notifications\ProjectTask;
use App\Http\Requests\TaskRequest;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Task;

class TaskController extends ApiController
{
  
  public function index(Project $project)
  {
    return $project->tasks()->latest()->get();
  }

  public function store(Project $project,TaskRequest $request)
  {
    $project->tasks()->create($request->validated());

    $this->sendNotification($project,new ProjectTask($project));

    $this->recordScore($project,'Task Added',10);
  }

  public function update(Project $project,Task $task,TaskRequest $request)
  {
    $task->update($request->validated());

    if(request('completed')){
       $task->complete();
      }else{
       $task->incomplete();
      }
    }
    
  public function destroy(Project $project,Task $task)
  {
    $task->delete();

    $task->activity()->delete();

    $project->recordActivity('deleted_task',$task->body);
  }

}
