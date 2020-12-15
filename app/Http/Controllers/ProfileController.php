<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\User;
use Auth;

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


}
