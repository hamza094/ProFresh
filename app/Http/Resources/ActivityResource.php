<?php

namespace App\Http\Resources;
use Illuminate\Support\Str;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivityResource extends JsonResource
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
          'time' => $this->created_at->diffForHumans(),
        'subject_id' => $this->subject_type === "App\\Models\\Task" ? ($this->subject ? $this->subject->id : null) : $this->subject_type,
          'user'=>$this->user,
        ];
    }

  protected function created_project()
  {
      return 'Project created';
  }

  protected function updated_project()
  {
    if(key($this->changes['after']) == 'stage_id')
    {
      return 'Project stage updated';
    }

    if(key($this->changes['after']) == 'deleted_at')
    {
      return 'Projet back alive';
    }

      return 'Project'.' '.key($this->changes['after']).' '.'updated';
  }

  protected function deleted_project()
  {
      return 'Project abandoned';
  }

  protected function restored_project()
  {
      return 'Project restores back';
  }

  protected function created_task()
  {
      if ($this->subject && $this->subject->body) {
        return 'Task'.' '.Str::limit($this->subject->body, 17, '..').' '.'added';
    }
    return 'Task added';
  }

  protected function updated_task()
  {
    $task = $this->subject;
    $updatedKey = key($this->changes['after']);
    $taskName = Str::limit($task->body, 17, '..');

    if ($updatedKey === 'completed') {
        return "Task '$taskName' status updated";
    }

    return "Task '$taskName' body updated";
  }

  protected function deleted_task()
  {
    return 'Task archived from the project';
  }

  protected function created_message()
  {
    $status = $this->subject->delivered_at == null ? 'scheduled' : 'sent';

    return 'Message ' . Str::limit($this->subject->message, 17, '..') . ' ' . $status;
  }

  protected function sent_invitation_member()
  {
    return 'Project invitation sent to'.' '.$this->info;
  }

  protected function accept_invitation_member()
  {
    return 'Project invitation accepted by'.' '.$this->info;
  }

  protected function remove_project_member()
  {
    return 'Project member'.' '.$this->info.' '.' removed';
  }
}
