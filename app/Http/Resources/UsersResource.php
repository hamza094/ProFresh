<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UsersResource extends JsonResource
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
          'id'=>$this->id,
          'name'=>$this->name,
        ];
    }
        return [
          'id'=>$this->id,
          'name'=>$this->name,
          'username'=>$this->username,
          'email'=>$this->email,
          'timezone'=>$this->timezone,
          'isAdmin'=>$this->isAdmin(),
          'avatar' => $this->when($this->avatar,
                        fn()=>$this->avatar_path),
          $this->mergeWhen($this->email_verified_at, [
          'verified' => true,
      ]), 
        ];
    }
}
