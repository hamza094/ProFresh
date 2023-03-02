<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use Auth;
use App\Models\Paypal;
use App\Services\UserService;
use App\Http\Requests\UserRequest;

class ProfileController extends ApiController
{
  private $profileService;

  /**
    * Service For Profile Feature
    *
    * App\Service\ProfileService
    */
  public function __construct(UserService $userService)
  {
    $this->userService=$userService;
  }

    /**
     * Display the specified user.
     *
     * @param  int  $user
     */
  public function show(User $user)
  {
   /*$members=$user->members;

   //Get user paypal subscription status
   if(Paypal::where('user_id',$user->id)->exists())
   {
    $paypal='subscribed';
   }else{
   $paypal='unsubscribed';
   }

   //Show paypal plan
   $data=$this->userService->showPaypalPlan($user);

   return view('profile.show',compact('user',$user,'members',
     $members,'paypal',$paypal))->with($data);*/
  }

    /**
     * Store user avatar.
     *
     * @param  int  $user
     *
     * @param  \Illuminate\Http\Request  $request
     */
  public function avatar(User $user, Request $request)
  {
    $this->validate(request(), [
      'avatar'=>['required', 'image']]);

    $user_path=$this->storeFile($request,'avatar',$user->id);

    $user->update(['avatar_path'=>$user_path]);

    return response([], 204);
  }

  public function avatarDelete(User $user)
  {
    if($user->avatar_path!==null)
    {
      $user->update(['avatar_path'=>null]);
    }
  }

}
