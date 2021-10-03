<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use File;

class ProjectHelper extends Controller
{

  public function recordScore($project,$message,$count)
  {
    $project->scores()->where('message',$message)->exists() ?: $project->addScore($message,$count);
  }

    /**
     * Store file in s3 storage.
     *
     * @param  string $name, int $id
     */
  public function storeFile($request,$name,$id)
  {
    $file = $request->file($name);
    $filename = uniqid($id.'_').'.'.$file->getClientOriginalExtension();
    Storage::disk('s3')->put($filename, File::get($file), 'public');
    //Store Profile Image in s3
    $path = Storage::disk('s3')->url($filename);
    return $path;
  }

}