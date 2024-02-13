<?php

namespace App\Http\Resources;
use Illuminate\Support\Str;
use App\Http\Resources\ProjectsResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class UserActivitiesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'description' => $this->{$this->description}(),
            'project' => $this->whenLoaded('project') ? new ProjectsResource($this->project) : null,
           //'time' => $this->created_at,
            'time' => Carbon::create(now()->year, rand(1, 12), rand(1, 28)),
           'subject_id' => $this->subject_type === "App\\Models\\Task" ? ($this->subject ? $this->subject->id : null) : $this->subject_type,
           'color' => $this->color(),
           'user_id'=>$this->user_id,
        ];
    }

    protected function created_project()
    {
      return "Project {$this->project->name} created";
    }

    protected function updated_project()
    {
      if(key($this->changes['after']) == 'stage_id')
      {
        return "Project {$this->project->name} stage updated";
      }

      if(key($this->changes['after']) == 'deleted_at')
      {
        return "Projet {$this->project->name} back alive";
      }

      return 'Project '. $this->project->name .key($this->changes['after']).' '.'updated';
    }

  protected function deleted_project()
  {
      return "Project abandoned";
  }

  protected function restored_project()
  {
      return "Project {$this->project->name} restores back";
  }

  protected function created_task()
  {
      if ($this->subject && $this->subject->title) {
        return 'Task'.' '.Str::limit($this->subject->title, 12, '..').' '.'added in '. $this->project->name;
    }
    return "Task added in {$this->project->name}";
  }

  protected function updated_task()
  {
    $task = $this->subject;
    $updatedKey = key($this->changes['after']);
    $taskName = Str::limit($task->title, 12, '..');

    if ($updatedKey === 'completed') {
        return "Task '$taskName' status updated in {$this->project->name}";
    }

    return "Task '$taskName' body updated in {$this->project->name}";
  }

  protected function deleted_task()
  {
    return "Task archived from {$this->project->name}";
  }

  protected function created_message()
  {
    $status = $this->subject->delivered_at == null ? 'scheduled' : 'sent';

    return 'Message ' . Str::limit($this->subject->message, 12, '..') . ' ' . $status;
  }

  protected function sent_invitation_member()
  {
    return "Project {$this->project->name} invitation sent to {$this->info}";
  }

  protected function accept_invitation_member()
  {
    return "Project {$this->project->name} invitation accepted by {$this->info}";
  }

  protected function remove_project_member()
  {
    return "Project {$this->project->name} member {$this->info} removed";
  }

    protected function updated_taskstatus(){
     $label = $this->subject->label;
    return "Updated Task Status with label '$label'";
  }

   protected function created_taskstatus(){
    return "Created new Task Status";
  }

   protected function deleted_taskstatus(){
    return "Deleted Task status";
  }

  protected function updated_stage(){
     $name = $this->subject->name;
    return "Updated Stage with name '$name'";
  }

   protected function created_stage(){
    return "Created new Stage";
  }

   protected function deleted_stage(){
    return "Deleted Stage";
  }

  protected function color()
  {
    if (Str::startsWith($this->{$this->description}(), 'Project')) {
        return 'purple';
    } elseif (Str::startsWith($this->{$this->description}(), 'Task')) {
        return 'yellow';
    } else {
        return 'green';
    }
  }
  
}
