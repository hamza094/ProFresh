<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Project;
use App\Account;

class AccountController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }

  public function projectaccount(Project $project,Request $request)
  {

    $this->validate($request, [
        'title'=>'required',
        'country'=>'required',
        'address'=>'required',
        'number'=>'required',
        'industry'=>'required',
        'business'=>'required'

    ]);

    $account=Account::create([
        'title'=>$request->title,
        'project_id'=>$project->id,
        'country'=>$request->country,
        'address'=>$request->address,
        'zipcode'=>$request->zipcode,
        'employee'=>$request->employee,
        'website'=>$request->website,
        'number'=>$request->number,
        'industry'=>$request->industry,
        'revenue'=>$request->revenue,
        'business'=>$request->business
  ]);

      $project->update(['account_id'=>$account->id]);

    if(request()->wantsJson()){
    return['message'=>$project->path()];
   }

  }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
