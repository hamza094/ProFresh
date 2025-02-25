<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
          'description' => $this->{$this->description}(),
          'time' => $this->created_at->diffForHumans(),
        'subject_id' => $this->getSubjectId(),
          'user'=>$this->user,
        ];
    }

     /**
     * Get subject ID based on type.
     *
     * @return mixed
     */
    protected function getSubjectId()
    {
        if ($this->subject_type === "App\\Models\\Task") {
            return optional($this->subject)->id;
        }
        return $this->subject_type;
    }

  protected function created_project()
  {
      return 'Project created';
  }

  protected function updated_project(): string
  {
    $updatedKey = key(Arr::get($this->changes, 'after', [])) ?? '';

        return match ($updatedKey) {
            'stage_id' => 'Project stage updated',
            'deleted_at' => 'Project back alive',
            default => 'Project ' . $updatedKey . ' updated'
        };
  }

  protected function deleted_project(): string
  {
      return 'Project abandoned';
  }

  protected function restored_project(): string
  {
      return 'Project restores back';
  }

  protected function created_task(): string
  {
       if ($this->subject && $this->subject->body) {
        return 'Task'.' '.Str::limit($this->subject->body, 17, '..').' '.'added';
    }
    return 'Task added';
  }

  protected function updated_task(): string
  {
      $task = $this->subject;
    $updatedKey = key($this->changes['after']);
    $taskName = Str::limit($task->body, 17, '..');

    if ($updatedKey === 'completed') {
        return "Task '$taskName' status updated";
    }

    return "Task '$taskName' body updated";
  }

  protected function deleted_task(): string
  {
    return 'Task archived from the project';
  }

  protected function created_message(): string
  {
    $status = optional($this->subject)->delivered_at === null ? 'scheduled' : 'sent';

    return 'Message ' . Str::limit(optional($this->subject)->message ?? '', 17, '..') . ' ' . $status;
  }

  protected function sent_invitation_member(): string
  {
    return 'Project invitation sent to'.' '.$this->info;
  }

  protected function accept_invitation_member(): string
  {
    return 'Project invitation accepted by'.' '.$this->info;
  }

  protected function remove_project_member(): string
  {
    return 'Project member'.' '.$this->info.' '.' removed';
  }
}
