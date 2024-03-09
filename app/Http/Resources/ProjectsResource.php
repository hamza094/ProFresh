<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

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

      if ($request->is('api/v1/tasksdata')) {
        return [
            'name' => $this->name,
            'slug' => $this->slug,
            'state'=>$this->state,
            'links'=>[
             'self'=>"/api/v1/".$this->slug,
        ],
        ];
    }

      return [
        'id'=>$this->id,
        'name'=>$this->name,
        'slug'=>$this->slug,
        'status'=>$this->status,
        'stage'=>new StageResource($this->stage),
        'created_at'=>$this->created_at->diffforHumans(),
        'completed'=>$this->completed,
        'links'=>[
          'self'=>"/api/v1/".$this->slug,
        ],
      ];
    }
}
