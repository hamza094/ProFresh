<?php

namespace App\Http\Resources\Api\V1;
use App\Http\Resources\Api\V1\TaskStatusResource;
use App\Http\Resources\Api\V1\UsersResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

/**
 * @mixin \App\Models\Task
 */
class TaskResource extends JsonResource
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
         'description'=>$this->description,
         'status_id'=>$this->status_id,
         'status'=>new TaskStatusResource($this->whenLoaded('status')),

        'members'=>UsersResource::collection($this->whenLoaded('assignee')),

        'due_at_utc'=>$this->due_at,
         'notified'=>$this->notified,

         'due_at'=>$this->when($this->due_at,fn()=>
            \Timezone::convertToLocal(Carbon::parse($this->due_at))),
         
         'created_at'=>$this->created_at,
         'updated_at'=>$this->updated_at,
       ];
    }
}
