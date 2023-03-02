<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserInfoResource extends JsonResource
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
          'mobile'=>$this->mobile,
          'company'=>$this->company,
          'position'=>$this->position,
          'bio'=>$this->bio,
          'address'=>$this->address,
        ];
    }
}
