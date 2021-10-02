<?php
namespace App\Services;
use File;
use App\Models\Project;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserService extends \App\Http\Controllers\Api\ApiController
{
  /**
   * Show paypal plan.
   *
   * @param  int  $user 
  */
  public function showPaypalPlan($user)
  {
    return $data=[
      'intent' => $user->createSetupIntent(),
      'plans'=> $this->availablePlans()
    ];
   }

  /**
   * Get paypal plans.
   * 
  */
  protected function availablePlans()
  {
   return $availablePlans=[
    'price_1IJejOLbPiqgp3U5jzTsYjVW' =>'Monthly',
    'price_1IJepYLbPiqgp3U5mqEuYgQr' =>'Yearly',
    ];
   }

   public function updatePassword($user)
   {
      if (request('password')) {
          $user->password = Hash::make(request('password'));
          $user->save();
        }
   }
}

?>
