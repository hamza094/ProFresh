<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\User;
use Auth;
use Illuminate\Support\Facades\Storage;
use Image;
use File;

class ProfileController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }

  public function show(User $user){
    $members=$user->members;
   return view('profile.show',compact('user',$user,'members',$members));
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


}
