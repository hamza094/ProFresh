<?php
namespace App\Services\Api\V1;

use File;
use App\Enums\FileType;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Spatie\ImageOptimizer\OptimizerChainFactory;

class FileService
{
    
public function store($id, string $fileInputName, string $fileType): string
{
    $file = request()->file($fileInputName);

    if (!$file) {
        throw ValidationException::withMessages([
       'file'=>'File not found',
     ]);
    }

    $folderName = $this->getFolderName($fileType);
    $fileName = $this->getGeneratedFileName($id, $file);

    // optimize the image before uploading it
    $optimizerChain = OptimizerChainFactory::create();
    $optimizerChain->optimize($file->path());

    $s3Disk = Storage::disk('s3');

    try {
        $path = $s3Disk->putFileAs($folderName, $file, $fileName, 'public');
    } catch (\Exception $e) {
        throw ValidationException::withMessages([
                'file' => 'Error uploading file',
            ]);
    }

    return $s3Disk->url($path);
 }

   private static function getFolderName(string $fileType): string
   {
     return match ($fileType) {
        FileType::CONVERSATION => 'conversations',
        FileType::AVATAR => 'avatars',
          default => throw new \InvalidArgumentException('Invalid file type'),
        };
    }

   private function getGeneratedFileName($id, UploadedFile $file): string
    {
        return $id . '_' . $file->hashName();
    }

    public function deleteFile($user){

     DB::transaction(function () use ($user) {

     $filePath=Str::after($user->avatar,'.com/');

     Storage::disk('s3')->delete($filePath);

     $user->update(['avatar_path' => null]);
     });

    }

}


?>