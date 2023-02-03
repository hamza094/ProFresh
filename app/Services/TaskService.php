<?php
namespace App\Services;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TaskService
{ 
  public function checkLimits($project){
    if($project->tasksReachedItsLimit())
    {
       throw ValidationException::withMessages([
        'task'=>'Project tasks reached their limit',
      ]);
    }
  }

  public function checkRecentlyCreated($task){
     if(!$task->wasRecentlyCreated)
     {
       throw ValidationException::withMessages([
         'task'=>'Project tasks already exist',
       ]);
     }
  }
  
}



?>
