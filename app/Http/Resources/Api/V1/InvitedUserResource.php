<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;
use Carbon\Carbon;

/**
 * @mixin \App\Models\User
 */
class InvitedUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray(Request $request): array
    {
        return [
          /**
           * User Uuid
           *  @example 9b8ea076-6d80-4076-8a01-73b94f4c0bc3
          * */
          'uuid'=>$this->uuid,

          /**
           *  @example Berry Allen 
          * */
          'name'=>$this->name,

          /**
           * User's username
           *  @example berry
          * */
          'username'=>$this->username,

          /**
           *  @example user@example.com
          * */
          //'email'=>$this->email,
          
          /**
           * User's avatar path
           * @example 'https://eu.ui-avatars.com/api/?name=Prof. Jonas Miller DVM'
           * */
          'avatar' => $this->when(!empty($this->avatar_path), fn () => $this->avatar_path),

       'invitation_sent_at' => $this->when(
        $request->routeIs('project.pending.invitation') && $this->pivot,
        fn() => Carbon::parse($this->pivot->created_at)->format('M j, Y \a\t g:i A')
    ),

       /**
        * Links related to the user.
        * @example {
        *   "self": "/api/v1/users/9b8ea076-6d80-4076-8a01-73b94f4c0bc3"
        * }
        */
          'links'=>[
            'self' => "/api/v1/users/".$this->uuid,
          ]

        ];
    }
}
