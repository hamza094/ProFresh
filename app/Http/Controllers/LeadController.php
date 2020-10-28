<?php

namespace App\Http\Controllers;

use App\LeadScore;
use App\Http\Requests\StoreLead;
use Illuminate\Http\Request;
use App\Lead;
use Auth;
use Illuminate\Support\Facades\Storage;
use Image;
use File;


class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

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
    public function store(StoreLead $request)
    {
        $lead=lead::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'owner'=>$request->owner,
            'zipcode'=>$request->zipcode,
            'mobile'=>$request->mobile,
            'address'=>$request->address,
            'position'=>$request->position,
            'company'=>$request->company
      ]);
        if(request()->wantsJson()){
        return['message'=>$lead->path()];
       }


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $lead=Lead::findorFail($id);
        $score=$lead->scores()->sum('point');
        return view('lead.show',compact('lead',$lead,'score',$score));

    }

    public function count(){

        return Lead::all()->count();

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
    public function update(Request $request,Lead $lead)
    {
        $this->validate($request, [
            'name'=>'required',
            'owner'=>'required',
            'email'=>'required',
            'mobile'=>'required'

        ]);

        $lead->update(request(['name','owner','email','zipcode','mobile',
            'address','position','status']));

        if (request()->wantsJson()) {
            return response($lead, 201);
        }

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

    public function avatar(Lead $lead, Request $request){
        $this->validate(request(), [
            'avatar'=>['required', 'image']
        ]);
        if($lead->avatar_path==null){
            $lead->addScore('avatar uploaded',15);
        }
        $file = $request->file('avatar');
        $filename = uniqid($lead->id.'_').'.'.$file->getClientOriginalExtension();
        Storage::disk('s3')->put($filename, File::get($file), 'public');
        //Store Profile Image in s3
        $lead_path = Storage::disk('s3')->url($filename);
        $lead->update(['avatar_path'=>$lead_path]);
        return response([], 204);
    }

    public function stage(Request $request, Lead $lead){
      $this->validate($request, [
          'stage'=>'required',
      ]);

      $lead->update(request(['stage']));

      if (request()->wantsJson()) {
          return response($lead, 201);
      }
    }

    public function unqualifed(Request $request,Lead $lead){
      $this->validate($request, [
          'unqualifed'=>'required',
          'stage'=>'required'
      ]);
      $lead->update(request(['unqualifed','stage']));

      if (request()->wantsJson()) {
          return response($lead, 201);
      }

    }

}