<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class SubscriptionController extends Controller
{
    public function subscribe(Request $request){
       $payLink=auth()->user()->newSubscription('monthly', $premium = config('services.monthly'))->create();

              return response()->json([
            'paylink' => $payLink,
        ]);
    }
}

