<?php

namespace App\Http\Resources\Api\V1;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

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
          * @example "The rise of plant"
          */ 
         'title'=>Str::ucfirst($this->title),

         /**
          * TaskStatus Resource
          */ 
         'status'=>new TaskStatusResource($this->whenLoaded('status')),

         /**
         * Task due at at user timezone
         * 
         * @example '19th December 2024 3:25:pm'
         */
         'due_at'=>$this->when($this->due_at,fn()=>
            \Timezone::convertToLocal(Carbon::parse($this->due_at))),
          /**
         * Task created date time
         * 
         * @example 'Dec 15th 24'
         */
         'created_at'=>$this->created_at->isoFormat('MMMM Do YYYY, h:mm:ss a'),

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
