<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectStageResource extends JsonResource
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
        'stage'=>$this->when($this->stage()->exists(),
        fn()=>new StageResource($this->stage)
        ),
        $this->mergeWhen($this->completed, [
          'completed' => $this->completed,
      ]),
      $this->mergeWhen($this->postponed != null, [
        'postponed'=>$this->postponed,
    ]),
        'stage_updated_at'=>$this->stage_updated_at->format("F j, Y, g:i a"),
      ];
    }
}