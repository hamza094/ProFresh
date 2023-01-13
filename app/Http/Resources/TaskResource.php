<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

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
         'body'=>$this->body,
         'completed'=>$this->completed,
         'created_at'=>$this->created_at->format(config('app.date_formats.exact')),
         
         'updated_at'=>$this->updated_at->format(config('app.date_formats.exact')),
       ];
    }
}
