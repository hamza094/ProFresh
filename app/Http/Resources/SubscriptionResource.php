<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionResource extends JsonResource
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
        $this->mergeWhen($this->isSubscribed(), [
          'subscribed' => true,
          'plan' => $this->subscribedPlan(),
      ]),
      'grace_period' => $this->when($this->hasGracePeriod(), true),
      'receipts' => $this->receipts,
      ];
    }
}
