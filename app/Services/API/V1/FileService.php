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
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Spatie\ImageOptimizer\OptimizerChainFactory;

class FileService
{
    
// Stores a file in S3 and returns its public URL

public function store(int $id, string $fileInputName, string $fileType): string
{
    $file = request()->file($fileInputName);

    if (!$file) {
        throw ValidationException::withMessages([
       'file'=>'File not found',
     ]);
    }

    $folderName = $this->getFolderName($fileType);
    $fileName = $this->getGeneratedFileName($id, $file);

    // If the file is an image, optimize it before uploading
    $this->optimizeFile($file);

    return $this->uploadFileToS3($folderName, $file, $fileName);

 }

   /* Returns the appropriate folder name for the file type.*/
   private static function getFolderName(string $fileType): string
   {
     return match ($fileType) {
        FileType::CONVERSATION => 'conversations',
        FileType::AVATAR => 'avatars',
          default => throw new \InvalidArgumentException('Invalid file type'),
        };
    }
   
    /*Generates a unique file name for the file using the project id and file hash.*/
   private function getGeneratedFileName(int $id, UploadedFile $file): string
    {
        return $id . '_' . $file->hashName();
    }

    private function optimizeFile(UploadedFile $file): void
  {
    OptimizerChainFactory::create()->optimize($file->path());
  }


  private function uploadFileToS3(string $folderName, UploadedFile $file, string $fileName): string
  {
    $s3Disk = Storage::disk(config('filesystems.cloud'));

    try {
        $path = $s3Disk->putFileAs($folderName, $file, $fileName, 'public');
    } catch (\Exception $e) {
        Log::error('File upload failed', ['error' => $e->getMessage()]);
        throw ValidationException::withMessages(['file' => 'Error uploading file']);
    }
    return $s3Disk->url($path);
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