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


    // Generate a unique filename for the image file using the uniqid function and the original file extension of the image file
    $filename = uniqid($id.'_').'.'.$file->getClientOriginalExtension();

    // Store the image file on S3 using the put method of the S3 disk.
    Storage::disk('s3')->put($filename, File::get($file), 'public');

    // Store the image file in S3
    $path = Storage::disk('s3')->url($filename);
    
    return $path;
  } 

}



?>