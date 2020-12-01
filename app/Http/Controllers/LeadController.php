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
use App\Mail\LeadMail;
use Illuminate\Support\Facades\Mail;
use App\Functions\LeadFunction;
use Twilio\Rest\Client;
use App\Exports\LeadsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Activity;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redis;
use App\User;

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
            'user_id'=>auth()->id(),
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
        $scores=$lead->scores()->sum('point');
        return view('lead.show',compact('lead',$lead,'scores',$scores));

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
     * forget the specified resource from database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lead $lead)
    {
        $lead->delete();
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

      $redis = Redis::connection();

      $key = 'stage_update_' . $lead->id;
      $value = (new \DateTime())->format("Y-m-d H:i:s");
      $redis->set($key, $value);

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

//Lead Trash Delete
   public function delete(Lead $lead){
     $lead->forceDelete();
     $lead->activity()->delete();

        if(request()->expectsJson()){
            return response(['status'=>'lead deleted']);
        }
   }

   public function avatarDelete(Lead $lead){
    if($lead->avatar_path!==null){
   $lead->update(['avatar_path'=>null]);
    $lead->scores()->where('message','avatar uploaded')->delete();
     }

}

public function mail(Lead $lead,Request $request){
  //Send Ticket Mail
        Mail::to($lead->email)->send(
            new LeadMail($request->subject,$request->message)
        );
        $lead->recordActivity('mail_sent');

}

//Send sms on verified numbers
public function sms(Lead $lead,Request $request){
  $this->validate($request, [
      'mobile'=>'required|numeric',
      'sms'=>'required'
  ]);
  LeadFunction::sendMessage($request->sms,$request->mobile);
  $lead->recordActivity('sms_sent');
}

// Download Lead Data Excel Export
public function export(Lead $lead){
  $lead->recordActivity('excel_export');
  return (new LeadsExport($lead))->download("lead$lead->id.xlsx");
}

public function activity(Lead $lead){
  $activity=Lead::where('id',$lead->id);
  return view('lead.activities',compact('lead',$activity));
}

public function user(){
  return User::latest()->get();
}

}
