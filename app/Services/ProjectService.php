<?php
namespace App\Services;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Models\Conversation;

class ProjectService
{
  
  public function sameRequestAttributes($project)
  {
      return $project->name == request('name')
      || $project->about == request('about');
  }

  public function sameNoteRequest($project)
  {
     return request()->has('notes')
     && $project->notes == request('notes');
  }

}



?>
