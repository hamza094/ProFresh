<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\V1\ReceiptResource;

/**
 * @mixin \App\Models\User
 */
class SubscriptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            $this->mergeWhen($this->isSubscribed(), [
                'subscribed' => true,
                'plan' => $this->subscribedPlan(),
            ]),
            
            'grace_period' => $this->when(
                $this->hasGracePeriod(), true),

            'receipts' => $this->when($this->isSubscribed(), fn () => ReceiptResource::collection($this->receipts)),

            'next_payment'=>$this->payment(),
        ];
    }
}
