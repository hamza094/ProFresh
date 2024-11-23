<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Stage
 */
class StageResource extends JsonResource
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
         * @example 1
        */
          'id' => $this->id,

        /**
         * @example Planing
        */
          'name' => $this->name,
        ];
    }
}
