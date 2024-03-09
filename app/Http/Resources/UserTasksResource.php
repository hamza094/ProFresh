<?php

namespace App\Http\Resources;

use App\Http\Resources\ProjectsResource;
use App\Http\Resources\TaskStatusResource;
use App\Http\Resources\UsersResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserTasksResource extends JsonResource
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
         'id'=>$this->id,
         'title'=>$this->title,
         'status'=>new TaskStatusResource($this->whenLoaded('status')),
         'project'=>new ProjectsResource($this->whenLoaded('project')),
         'assignee'=>UsersResource::collection($this->whenLoaded('assignee')),
         'due_at'=>$this->when($this->due_at,fn()=>
            \Timezone::convertToLocal(Carbon::parse($this->due_at))),
         'state' => $this->when($this->user_id !== auth()->id(), 'assigned', 'created'),
         'created_at'=>$this->created_at->diffForHumans(),
       ];
    }
}
