<?php
namespace App\Services;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TaskService
{ 
  public function checkLimits($project)
  {
    throw_if($project->tasksReachedItsLimit(),
      ValidationException::withMessages(
        ['task'=>'Project tasks reached their limit'])
      );
  }

  public function checkRecentlyCreated($task)
  {
    throw_unless($task->wasRecentlyCreated,
       ValidationException::withMessages(
        ['task'=>'Project tasks already exist'])
     );
     
  }

  public function perventDuplication($validatedData){
      if ($task->body === $validatedData['body']) {
        return $this->respondError("You haven't changed anything");
    }
  }


  
}



?>
