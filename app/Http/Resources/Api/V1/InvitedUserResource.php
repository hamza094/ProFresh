<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class InvitedUserResource extends JsonResource
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
           * User Uuid
           *  @example 9b8ea076-6d80-4076-8a01-73b94f4c0bc3
          * */
          'uuid'=>$this->uuid,

          /**
           *  @example berry 
          * */
          'name'=>$this->name,

          /**
           *  @example user@example.com
          * */
          'email'=>$this->email,

       /**
        * Links related to the user.
        * @example {
        *   "self": "/api/v1/users/9b8ea076-6d80-4076-8a01-73b94f4c0bc3"
        * }
        */
          'links'=>[
            'self' => "/api/v1/users".$this->uuid,
          ]

        ];
    }
}
