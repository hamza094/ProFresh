<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SubscriptionResource;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;

class SubscriptionController extends Controller
{
    use ApiResponseHelpers;

     protected $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = auth()->user();
            return $next($request);
        });
    }

    public function subscribe(Request $request){
       $payLink=$this->user->newSubscription('monthly', $premium = config('services.paddle.monthly'))->create();

              return response()->json([
            'paylink' => $payLink,
        ]);
    }

    public function subscriptions()
    {
      return response()->json([
      'subscription' => new SubscriptionResource($this->user),
    ], 200);
    }

    public function swap($plan)
    {
      $currentPlan=$this->user->subscribedPlan();

      $this->user->subscription($currentPlan)->swap($premium = config('services.paddle.'.$plan));

       return $this->respondWithSuccess([
        'message'=>'Your subscription has been successfully updated to the ' .$plan. ' plan',
        'subscription' => new SubscriptionResource($this->user),
      ]);
    }

    public function cancel($plan)
    {   
      $this->user->subscription($plan)->cancel();

       return $this->respondWithSuccess([
        'message' => 'Your subscription has been canceled successfully.',
        'subscription' => new SubscriptionResource($this->user),
      ]);
    }
}

