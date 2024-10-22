<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\SubscriptionResource;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;

class SubscriptionController extends Controller
{
    use ApiResponseHelpers;

    public function subscribe($plan)
    {       
      $payLink=auth()->user()->newSubscription($plan,config('services.paddle.'.$plan))
      ->returnTo('http://localhost:8000/subscriptions')
      ->create();

        return response()->json([
            'paylink' => $payLink,
        ]);
    }

    public function subscriptions()
    {
      return response()->json([
      'subscription' => new SubscriptionResource(auth()->user()),
    ], 200);
    }

    public function swap($plan)
    {
      try{
      $currentPlan=auth()->user()->subscribedPlan();

      auth()->user()->subscription($currentPlan)->swap(config('services.paddle.'.$plan));

       return $this->respondWithSuccess([
        'message'=>'Your subscription has been successfully updated to the ' .$plan. ' plan',
        'subscription' => new SubscriptionResource(auth()->user()),
      ]);
     } catch(\Exception $e){
        $this->respondError($e->getMessage());
     }
    }

    public function cancel($plan)
    {   
      try{
      auth()->user()->subscription($plan)->cancel();

       return $this->respondWithSuccess([
        'message' => 'Your subscription has been canceled successfully.',
        'subscription' => new SubscriptionResource(auth()->user()),
      ]);
     } catch(\Exception $e){
        $this->respondError($e->getMessage());
     }
    }

    
}

