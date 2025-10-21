<?php
namespace App\Services\Api\V1\Admin\Integration;

use App\Collections\Paddle\DataCollection;
use App\DataTransferObjects\Paddle\UserSubscriptionData;
use App\DataTransferObjects\Paddle\Data;
use App\Http\Integrations\Paddle\PaddleConnector;
use App\Http\Resources\Api\V1\Admin\Integration\PaddleResource;
use App\Interfaces\PaddleApi;
use App\Http\Integrations\Paddle\Requests\SubscriptionUsersList;
use Illuminate\Pagination\LengthAwarePaginator;

final class PaddleService implements PaddleApi
{
    private function connector(): PaddleConnector
    {
      return app(PaddleConnector::class);
    }

  public function subscriptionUsersList(UserSubscriptionData $listData): DataCollection 
   {
     $subscriptionsData = $this->connector()
      ->send(new SubscriptionUsersList($listData))
      ->collect();

      $subscriptions = collect($subscriptionsData['response']);

  $filteredSubscriptions = $subscriptions->map(function ($subscription) {
     return new Data(
        $subscription['user_id'] ?? 0, 
        $subscription['user_email'] ?? 0,
        $subscription['signup_date'] ?? 0,
        $subscription['last_payment']['amount'] ?? 0,
        $subscription['last_payment']['currency'] ?? 0,
        $subscription['last_payment']['date'] ?? 0,
        $subscription['next_payment']['date'] ?? 0,
    );
    })->filter(); 

      return DataCollection::make($filteredSubscriptions);
   }
   
}
