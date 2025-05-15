<?php

namespace App\Interfaces;

use App\Collections\Paddle\DataCollection;
use App\DataTransferObjects\Paddle\UserSubscriptionData;
use App\DataTransferObjects\Paddle\Data;

interface PaddleApi
{
  public function subscriptionUsersList(
       UserSubscriptionData $subscriptionData
    ): DataCollection;
  
}