<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\User;
use Auth;
use App\Paypal;
use App\Services\UserService;
use App\Http\Requests\UserRequest;

class ProfileController extends Controller
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

    $this->middleware('can:owner,user')->except('show');
  }

    /**
     * Display the specified user.
     *
     * @param  int  $user
     */
  public function show(User $user)
  {
   $members=$user->members;

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
     $members,'paypal',$paypal))->with($data);
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

    /**
     * Delete user avatar.
     *
     * @param  int  $user
     */
  public function avatarDelete(User $user)
  {
    if($user->avatar_path!==null)
    {
      $user->update(['avatar_path'=>null]);
    }
  }

  /**
     * Update the specified resource in storage.
     *
     * @param  int  $user
     * 
     * @return  \Illuminate\Http\Request  $request
     */
  public function update(UserRequest $request,User $user)
  {
    $user->update($request->validated());

    $this->userService->updatePassword($user);       
  }

   /**
     * Delete the specified resource from database.
     *
     * @param  int  $user
     */
  public function destroy(User $user)
  {
    $user->delete();

    if(request()->expectsJson())
    {
      return response(['status'=>'profile deleted']);
    }
  }
}
