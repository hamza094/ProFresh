<?php

namespace App\Http\Resources\Api\V1;

use App\Http\Resources\Api\V1\ProjectsResource;
use App\Http\Resources\Api\V1\TaskStatusResource;
use App\Http\Resources\Api\V1\UsersResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class UserTasksResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */

   /**
   * @mixin \App\Models\Task
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
