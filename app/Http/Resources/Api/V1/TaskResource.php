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
       $showRoute = $request->routeIs('tasks.show');
       
       return [
         'id'=>$this->id,
         /**
          * Task Id
          * 
          * @example "the rise of plant"
          */ 
         'title'=>$this->title,
         /**
          * Task Description
          * 
          * @example "this is the description of task"
          */ 
         'description'=>$this->description,
         /**
          * Task Satus id
          * 
          * @example 1
          */ 

         'status_id'=>$this->status_id,

         /**
          * TaskStatus Resource
          */ 
         'status'=>new TaskStatusResource($this->whenLoaded('status')),

         /*
         * Users associated to task
         */
         'members' => $this->when(
            $showRoute,
            fn () => UsersResource::collection($this->whenLoaded('assignee'))
        ),

        /**
         * Task Due at UTC timezone
         * 
         * @example 2024-12-09T10:25:00.000000
         */ 
        'due_at_utc'=>$this->due_at,

        /**
         * Task notified wheater notificatopn sent to asinee or not
         */ 
         'notified'=>$this->notified,

         /**
         * Task due at at user timezone
         * 
         * @example '9th December 2024 3:25:pm'
         */

         'due_at'=>$this->when($this->due_at,fn()=>
            \Timezone::convertToLocal(Carbon::parse($this->due_at))),
         
         'created_at'=>$this->created_at,
         'updated_at'=>$this->updated_at,
       ];
    }
}
