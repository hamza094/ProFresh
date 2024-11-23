<?php

namespace App\Http\Controllers\Api\V1\Admin\Integration;

use App\Http\Controllers\Controller;
use App\Services\Api\V1\Admin\Intgration\PaddleService;
use App\DataTransferObjects\Paddle\UserSubscriptionData;
use App\Interfaces\Paddle;

class PaddleController extends Controller
{ 
     public function subscribedUsers(Paddle $paddle)
 { 
    //try {
    $data =  $paddle->SubscriptionUsersList(
      new UserSubscriptionData(
        vendorID: (int)config('services.paddle.vendor_id'),
        vendorAuthCode: config('services.paddle.vendor_auth_code'),
        resultsPerPage: config('services.paddle.results_per_page')
     )
    );
   //} catch(GitHubException $exception){
    //return response()->json(['error'=>$exception->getMessage()]);
   //}  


    return response()->json(['data'=>$data]);       

 }
}
