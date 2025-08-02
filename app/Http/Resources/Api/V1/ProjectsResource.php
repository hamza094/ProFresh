<?php

namespace App\Http\Resources\Api\V1;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\V1\StageResource;

/**
 * @mixin \App\Models\Project
 */
class ProjectsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

      /*if ($request->is('api/v1/tasksdata')) {
        return [
            'name' => $this->name,
            'slug' => $this->slug,
            'state'=>$this->state,
            'links'=>[
             'self'=>"/api/v1/".$this->slug,
        ],
        ];
    }*/

      return [
      /**
       * @example 1
      */
        'id'=>$this->id,

      /**
       * @example The Dimension
      */
        'name'=>$this->name,

      /**
       * @example the-dimension
      */
        'slug'=>$this->slug,

      /**
       * Project status calculated on the based of score
       * 
       * @example cold
      */
        'status'=>$this->status,

      /**
       * Details of the current stage of the project.
      */
        'stage'=>new StageResource($this->stage),

      /**
       * The human-readable creation date of the project.
       * @example "2 hours ago"
     */
        'created_at'=>$this->created_at->diffForHumans(),

          /**
     * Links related to the project.
     * @example {
     *   "self": "/api/v1/projects/the-dimension"
     * }
     */
        'links'=>[
          'self'=>"/api/v1/projects/".$this->slug,
        ],
      ];
    }
}
