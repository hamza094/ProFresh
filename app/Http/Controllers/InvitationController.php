<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Spatie\Searchable\Search;
use App\Project;
use Auth;

class InvitationController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }
  public function search(Request $request)
   {
     $results = (new Search())
     ->registerModel(User::class, ['name', 'email'])
     ->search($request->input('query'));
   return response()->json($results);
   }

   public function store(Project $project,Request $request){
     $user=User::whereEmail(request('email'))->first();
     if (! $project->members->contains($user->id)) {
     $project->invite($user);
     $project->recordActivity('sent_member',$user->name.'/_/'.$user->id);
     if(!$project->scores()->where('message','Invitaion Sent')->exists()){
       $project->addScore('Invitaion Sent',5);
     }
   }
  }

  public function accept(Project $project){
    $user=Auth::user();
     $user->members()->updateExistingPivot($project,['active'=>1]);
     $project->recordActivity('accept_member',$user->name.'/_/'.$user->id);
     $project->addScore("Invitaion Accept by $user->name",15);
  }
}