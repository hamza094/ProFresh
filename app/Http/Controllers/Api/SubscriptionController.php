<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SubscriptionResource;
use Illuminate\Http\Request;
use App\Models\User;

class SubscriptionController extends Controller
{
    public function subscribe(Request $request){
       $payLink=auth()->user()->newSubscription('monthly', $premium = config('services.paddle.monthly'))->create();

              return response()->json([
            'paylink' => $payLink,
        ]);
    }

    public function subscriptions()
    {
      $user=auth()->user();

       return response()->json([
      'subscription' => new SubscriptionResource($user),
    ], 200);
    }
}

