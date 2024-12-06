<?php

namespace App\Http\Resources\Api\V1;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Task
 */
class TasksResource extends JsonResource
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
        /**
          * Task Id
          * 
          * @example 1
        */
        'id'=>$this->id,

         /**
          * Task Title
          * 
          * @example "the rise of plant"
          */ 
         'title'=>$this->title,

         /**
          * TaskStatus Resource
          */ 
         'status'=>new TaskStatusResource($this->whenLoaded('status')),

         /**
         * Task due at at user timezone
         * 
         * @example '9th December 2024 3:25:pm'
         */
         'due_at'=>$this->when($this->due_at,fn()=>
            \Timezone::convertToLocal(Carbon::parse($this->due_at))),
         
         'created_at'=>$this->created_at,

        /**
         * Links related to the project.
         * @example {
         * "self": "/api/v1/projects/the-dimension/tasks/1"
         * }
        */
         'links'=>[
            'self'=>"/api/v1/projets/".$this->project->slug.'/tasks/'.$this->id
         ]
        ];
    }
}
