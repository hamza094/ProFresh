<?php

namespace App\Http\Controllers;
use App\ProjectScore;
use App\Http\Requests\StoreProject;
use Illuminate\Http\Request;
use App\Project;
use Auth;
use Illuminate\Support\Facades\Storage;
use Image;
use File;
use App\Mail\ProjectMail;
use Illuminate\Support\Facades\Mail;
use App\Functions\ProjectFunction;
use Twilio\Rest\Client;
use App\Exports\ProjectsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Activity;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redis;
use App\User;
use Spatie\Searchable\Search;

class ProjectController extends Controller
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
    public function store(StoreProject $request)
    {
        $project=project::create([
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
        return['message'=>$project->path()];
       }


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        $scores=$project->scores()->sum('point');
        $members=$project->members->where('pivot.active',1);
        return view('project.show',compact('project',$project,'scores',$scores,'members',$members));

    }

    public function count(){

        return Project::all()->count();

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
    public function update(Request $request,Project $project)
    {
        $this->validate($request, [
            'name'=>'required',
            'owner'=>'required',
            'email'=>'required',
            'mobile'=>'required'

        ]);

        $project->update(request(['name','owner','email','zipcode','mobile',
            'address','position','status']));

        if (request()->wantsJson()) {
            return response($project, 201);
        }

    }

    /**
     * forget the specified resource from database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();
    }

    public function avatar(Project $project, Request $request){
        $this->validate(request(), [
            'avatar'=>['required', 'image']
        ]);
        if($project->avatar_path==null){
            $project->addScore('avatar uploaded',15);
        }
        $file = $request->file('avatar');
        $filename = uniqid($project->id.'_').'.'.$file->getClientOriginalExtension();
        Storage::disk('s3')->put($filename, File::get($file), 'public');
        //Store Profile Image in s3
        $project_path = Storage::disk('s3')->url($filename);
        $project->update(['avatar_path'=>$project_path]);
        return response([], 204);
    }

    public function stage(Request $request, Project $project){
      $this->validate($request, [
          'stage'=>'required',
      ]);

      $project->update(request(['stage']));

      $redis = Redis::connection();

      $key = 'stage_update_' . $project->id;
      $value = (new \DateTime())->format("Y-m-d H:i:s");
      $redis->set($key, $value);

      if (request()->wantsJson()) {
          return response($project, 201);
      }
    }

    public function unqualifed(Request $request,Project $project){
      $this->validate($request, [
          'unqualifed'=>'required',
          'stage'=>'required'
      ]);
      $project->update(request(['unqualifed','stage']));

      if (request()->wantsJson()) {
          return response($project, 201);
      }
   }

//Project Trash Delete
   public function delete(Project $project){
     $project->forceDelete();
     $project->activity()->delete();

        if(request()->expectsJson()){
            return response(['status'=>'project deleted']);
        }
   }

   public function avatarDelete(Project $project){
    if($project->avatar_path!==null){
   $project->update(['avatar_path'=>null]);
    $project->scores()->where('message','avatar uploaded')->delete();
     }

}

public function mail(Project $project,Request $request){
  //Send Project Member Mail
        Mail::to($request['email'])->send(
            new ProjectMail($request->subject,$request->message)
        );
        $project->recordActivity('mail_sent');

}

//Send sms on verified numbers
public function sms(Project $project,Request $request){
  $this->validate($request, [
      'mobile'=>'required|numeric',
      'sms'=>'required'
  ]);
  ProjectFunction::sendMessage($request->sms,$request->mobile);
  $project->recordActivity('sms_sent');
}

// Download Project Data Excel Export
public function export(Project $project){
  $project->recordActivity('excel_export');
  return (new ProjectsExport($project))->download("project$project->id.xlsx");
}

public function activity(Project $project){
  $activity=Project::where('id',$project->id);
  return view('project.activities',compact('project',$activity));
}

public function user(){
  return User::latest()->get();
}

public function notes(Project $project,Request $request){
  $this->validate($request, [
      'notes'=>'required',
  ]);
  $project->update(['notes'=>request('notes')]);
}

public function search(Request $request)
 {
   $results = (new Search())
   ->registerModel(User::class, ['name', 'email'])
   ->search($request->input('query'));
 return response()->json($results);
 }

}
