<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Conversation;
use App\Events\NewMessage;
use App\Project;
use Image;
use File;
use Illuminate\Support\Facades\Storage;


class ConversationController extends Controller
{
     public function store(Project $project,Request $request)
    {
        $group_id=$project->group->id;

        if(request()->has('file')){

        $this->validate($request, [
            'file'=>'required'

        ]);

            $file = $request->file('file');
        $filename = uniqid(auth()->user()->id.'_').'.'.$file->getClientOriginalExtension();
        Storage::disk('s3')->put($filename, File::get($file), 'public');
        //Store Profile Image in s3
        $project_path = Storage::disk('s3')->url($filename);


            $conversation = Conversation::create([
            'file' => $project_path,
            'group_id' => $group_id,
            'user_id' => auth()->user()->id,
        ]);
        }else{

            $this->validate($request, [
            'message'=>'required'

        ]);

        $conversation = Conversation::create([
            'message' => request('message'),
            'group_id' => $group_id,
            'user_id' => auth()->user()->id,
        ]);
}
        broadcast(new NewMessage($conversation))->toOthers();

        return $conversation->load('user');
    }

    public function conversation(Project $project){
        return $project->group->conversations->load('user');
    }
}
