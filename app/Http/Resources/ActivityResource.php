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
          'description'=>call_user_func_array([$this, $this->description],
           [$this]),
          'time' => $this->created_at->diffForHumans(),
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
      return 'Task'.' '.Str::limit($this->subject->body,17,'..').' '.'added';
  }

  protected function updated_task()
  {
    if(key($this->changes['after']) == 'completed'){
      return 'Task'.' '.Str::limit($this->subject->body,17,'..').' '.'status updated';
    }
      return 'Task'.' '.Str::limit($this->subject->body,17,'..').' '.'body updated';
  }

  protected function deleted_task()
  {
    return 'Task deleted from the project';
  }

  protected function created_message()
  {
    if($this->subject->delivered_at == null){
      return 'Message'.' '.Str::limit($this->subject->message,17,'..').' '.'scheduled';
    }
      return 'Message'.' '.Str::limit($this->subject->message,17,'..').' '.'sent';
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
