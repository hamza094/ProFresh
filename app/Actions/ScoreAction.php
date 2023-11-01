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

  public function calculateTotal(): int
  {  
    $total = 0;

    $total += $this->taskScore();
    $total += $this->notesScore();
    $total += $this->membersScore();

    return $total;
  }
   
   private function taskScore(): int
  {
    return $this->project->tasks_count * ScoreValue::Task;
  }

  private function notesScore(): int
  {
    return $this->project->notes !== null ? ScoreValue::Note : 0;
  }

  private function membersScore(): int
  {
    return $this->project
          ->active_members_count * ScoreValue::Members;
  }

}

?>
