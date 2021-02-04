<?php

namespace App\Http\Controllers;
use App\ProjectScore;
use App\Http\Requests\StoreProject;
use Illuminate\Http\Request;
use App\Project;
use Auth;
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
use App\Notifications\ProjectUpdated;
use App\Group;
use App\Conversation;


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
            'zipcode'=>$request->zipcode,
            'mobile'=>$request->mobile,
            'address'=>$request->address,
            'position'=>$request->position,
            'company'=>$request->company
      ]);

      $group = Group::create([
        'name' => $project->name . " Chat Group",
        'project_id'=>$project->id
      ]);

       $users=[];
       array_push($users, $project->user->id);

       $group->users()->attach($users);

       $project->update(['group_id'=>$group->id]);

       Conversation::create([
       'message'=>"Welcome to ". $project->name,
        'user_id'=>$project->user->id,
        'group_id'=>$group->id
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
        $projectgroup=$project->group;
        $cons=$project->group->conversations->count();
        return view('project.show',compact('project',$project,'scores',$scores,
          'members',$members,'projectgroup',$projectgroup,'cons',$cons));

      

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
            'email'=>'required',
            'mobile'=>'required'

        ]);

        $this->authorize('access',$project);

        $project->update(request(['name','email','zipcode','mobile',
            'address','position']));

            foreach($project->members->where('pivot.active',1) as $member){
              if(auth()->user()->id != $member->id){
                $member->notify(new ProjectUpdated($project));
              }
            }

            if(auth()->user()->id != $project->owner->id){
            $project->owner->notify(new ProjectUpdated($project));
          }

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
      $this->authorize('manage',$project);
        $project->delete();
    }


    public function stage(Request $request, Project $project){
      $this->validate($request, [
          'stage'=>'required',
      ]);
     $this->authorize('access',$project);

      $project->update(request(['stage']));

      $redis = Redis::connection();

      $key = 'stage_update_' . $project->id;
      $value = (new \DateTime())->format("Y-m-d H:i:s");
      $redis->set($key, $value);

      foreach($project->members->where('pivot.active',1) as $member){
        if(auth()->user()->id != $member->id){
          $member->notify(new ProjectUpdated($project));
        }
      }

      if(auth()->user()->id != $project->owner->id){
      $project->owner->notify(new ProjectUpdated($project));
    }

      if (request()->wantsJson()) {
          return response($project, 201);
      }
    }

    public function postponed(Request $request,Project $project){
      $this->validate($request, [
          'postponed'=>'required',
          'stage'=>'required'
      ]);
      $this->authorize('access',$project);


      $project->update(request(['postponed','stage']));

      foreach($project->members->where('pivot.active',1) as $member){
        if(auth()->user()->id != $member->id){
          $member->notify(new ProjectUpdated($project));
        }
      }

      if(auth()->user()->id != $project->owner->id){
      $project->owner->notify(new ProjectUpdated($project));
    }

      if (request()->wantsJson()) {
          return response($project, 201);
      }
   }

//Project Trash Delete
   public function delete(Project $project){
     $this->authorize('manage',$project);
     $project->forceDelete();
     $project->activity()->delete();

        if(request()->expectsJson()){
            return response(['status'=>'project deleted']);
        }
   }


public function mail(Project $project,Request $request){
  //Send Project Member Mail
        Mail::to($request['email'])->send(
            new ProjectMail($request->subject,$request->message)
        );
        $project->recordActivity('mail_sent',$request->email);

        if(!$project->scores()->where('message','Sent Mail')->exists()){
          $project->addScore('Sent Mail',10);
        };


}

//Send sms on verified numbers
public function sms(Project $project,Request $request){
  $this->validate($request, [
      'mobile'=>'required|numeric',
      'sms'=>'required'
  ]);
  ProjectFunction::sendMessage($request->sms,$request->mobile);
  $project->recordActivity('sms_project',$request->mobile);

  if(!$project->scores()->where('message','Sent Sms')->exists()){
    $project->addScore('Sent Sms',10);
  };
}

// Download Project Data Excel Export
public function export(Project $project){
  $project->recordActivity('export_project','default');
  return (new ProjectsExport($project))->download("project$project->id.xlsx");

  if(!$project->scores()->where('message','Excel Export')->exists()){
    $project->addScore('Excel Export',10);
  };

}

public function activity(Project $project){

  $activities=$project->activity();

  if ($id = request('mine')) {
              $user = User::where('id', $id)->firstOrFail();
              $activities->where('user_id', $user->id);
          }elseif(request('task')){
            $activities->where('description', 'LIKE', '%'.'_task'.'%');
          }elseif(request('appointment')){
           $activities->where('description', 'LIKE', '%'.'_appointment'.'%');
         }elseif(request('related')){
            $activities=$project->activity()->where('description', 'LIKE', '%'.'_project'.'%');
           }
          $activities = $activities->paginate(10);


  return view('project.activities.activities',compact('activities',$activities,'project',$project));
}

public function user(){
  return User::latest()->get();
}

public function notes(Project $project,Request $request){
  $this->validate($request, [
      'notes'=>'required',
  ]);
  $this->authorize('access',$project);

  $project->update(['notes'=>request('notes')]);

  foreach($project->members->where('pivot.active',1) as $member){
    if(auth()->user()->id != $member->id){
      $member->notify(new ProjectUpdated($project));
    }
   }

    if(auth()->user()->id != $project->owner->id){
   $project->owner->notify(new ProjectUpdated($project));
}

    if(!$project->scores()->where('message','Notes Updated')->exists()){
      $project->addScore('Notes Updated',10);
    }

}

public function search(Request $request)
 {
   $results = (new Search())
   ->registerModel(User::class, ['name', 'email'])
   ->search($request->input('query'));
 return response()->json($results);
 }

}
