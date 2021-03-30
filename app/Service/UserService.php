<?php
namespace App\Service;
use File;
use App\Project;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserService
{
  /**
    * Store user avatar in S3.
    *
    * @param  int  $user 
    */
  public function storeAvatar($user)
  {
    $file = $request->file('avatar');
    $filename = uniqid($user->id.'_').'.'.$file->getClientOriginalExtension();
    Storage::disk('s3')->put($filename, File::get($file), 'public');
    //Store Profile Image in s3
    $user_path = Storage::disk('s3')->url($filename);
    $user->update(['avatar_path'=>$user_path]);
   }

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

  /**
  * Update user password if exists.
  * 
  */
   public function updatePassword($user)
   {
      if (request('password')) {
          $user->password = Hash::make(request('password'));
          $user->save();
        }
   }
}

?>
