<?php
namespace App\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use File;

class FileService
{
    /**
     * Store file in s3 storage.
     *
     * @param  string $name, int $id
     */
  public function store($request,$name,$id)
  {
    $file = $request->file($name);
    $filename = uniqid($id.'_').'.'.$file->getClientOriginalExtension();
    Storage::disk('s3')->put($filename, File::get($file), 'public');
    //Store Profile Image in s3
    $path = Storage::disk('s3')->url($filename);
    return $path;
  } 

}



?>