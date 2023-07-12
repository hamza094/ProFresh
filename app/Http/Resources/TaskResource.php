<?php

namespace App\Http\Resources;
use App\Http\Resources\TaskStatusResource;
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
         'title'=>$this->title,
         'description'=>$this->description,
         'status_id'=>$this->status_id,
         'status'=>new TaskStatusResource($this->status),
         'due_date'=>$this->due_date,
         'created_at'=>$this->created_at->format(config('app.date_formats.exact')),

         'updated_at'=>$this->updated_at->format(config('app.date_formats.exact')),
       ];
    }
}
