<?php
namespace App\Actions;

use App\Models\User;
use App\Models\Project;
use App\Enums\ScoreValue;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ScoreAction
{ 
  private $project;

  public function __construct(Project $project)
  {
    $this->project = $project;
  }

  public function calculateTotal()
  {  
    return array_sum([
      $this->taskScore(),
      $this->notesScore(),
      $this->membersScore()
    ]);
  }
   
  private function taskScore()
  {
    return $this->project->tasks()->count() * ScoreValue::Task;
  }

  private function notesScore()
  {
    return $this->project->notes !== null ? ScoreValue::Note : 0;
  }

  private function membersScore()
  {
    return $this->project
          ->activeMembers()->count() * ScoreValue::Members;
  }

  public function getStatus()
  {
    return $this->calculateTotal() >= ScoreValue::Hot_Score 
             ? 'hot' : 'cold';
  }

}

?>
