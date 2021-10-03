<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;

class DashBoardController extends ApiController
{
    public function userprojects(Request $request){

        //Get data with request
        if ($request->filled('active')) {
             $projects = auth()->user()->projects()->with('scores','user')->get();
        } elseif ($request->filled('invited')) {
             $projects = auth()->user()->members;
        } elseif ($request->filled('trashed')) {
             $projects = auth()->user()->projects()->onlyTrashed()->get();
        }

        return response()->json($projects);
    }

    public function projectcount(){
      $projectcount=auth()->user()->projects->count();
      return response()->json($projectcount); 
    }
}
