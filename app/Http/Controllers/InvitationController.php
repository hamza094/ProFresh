<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Spatie\Searchable\Search;

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

}
