<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\User;
use Auth;
use Illuminate\Support\Facades\Storage;
use Image;
use File;
use App\Paypal;
class ProfileController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }

  public function show(User $user){
    //$members=$user->members;
if(Paypal::where('user_id',$user->id)->exists()){
  $paypal='subscribed';
}else{
  $paypal='unsubscribed';
}


     /*$availablePlans=[
       'price_1IJejOLbPiqgp3U5jzTsYjVW' =>'Monthly',
       'price_1IJepYLbPiqgp3U5mqEuYgQr' =>'Yearly',
    ];
    $data=[
      'intent' => $user->createSetupIntent(),
      'plans'=> $availablePlans
    ];

   return view('profile.show',compact('user',$user,'members',$members,'paypal',$paypal))->with($data);*/
}

  public function avatar(User $user, Request $request){
        $this->authorize('owner',$user);
        $this->validate(request(), [
            'avatar'=>['required', 'image']
        ]);
        $file = $request->file('avatar');
        $filename = uniqid($user->id.'_').'.'.$file->getClientOriginalExtension();
        Storage::disk('s3')->put($filename, File::get($file), 'public');
        //Store Profile Image in s3
        $user_path = Storage::disk('s3')->url($filename);
        $user->update(['avatar_path'=>$user_path]);
        return response([], 204);
    }

    public function avatarDelete(User $user){
      $this->authorize('owner',$user);
       if($user->avatar_path!==null){
      $user->update(['avatar_path'=>null]);
     }
  }

  public function update(Request $request,User $user)
    {
        
        $this->authorize('owner',$user);

        $this->validate($request, [
            'name'=>'required',
            'email'=>'required',
        ]);
        
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->mobile = $request->input('mobile');
        $user->company = $request->input('company');
        $user->bio = $request->input('bio');
        $user->address = $request->input('address');
        $user->position = $request->input('position');
        if (! $request->input('password') == '') {
            $user->password = Hash::make($request->input('password'));
        }
         $user->save();
    }

    public function destroy(User $user)
    {
      $this->authorize('owner',$user);
      $user->delete();
      if(request()->expectsJson()){
            return response(['status'=>'profile deleted']);
        }
    }

}
