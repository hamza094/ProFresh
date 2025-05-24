<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class ReceiptResource extends JsonResource
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
          'id' => $this->id,
          'created_at'=>\Timezone::convertToLocal(Carbon::parse($this->created_at)),
          'currency'=>$this->currency,
          'quantity'=>$this->quantity,
          'receipt_url'=>$this->receipt_url,
          'tax'=>$this->tax,
          'amount'=>$this->amount,
          'updated_at'=>$this->updated_at->diffForHumans()
        ];
    }
}
