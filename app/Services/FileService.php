<?php
namespace App\Services;

use File;
use App\Enums\FileType;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

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

    try {
        $path = Storage::disk('s3')->putFileAs($folderName, $file, $fileName, 'public');
    } catch (\Exception $e) {
        throw ValidationException::withMessages([
                'file' => 'Error uploading file',
            ]);
    }

    return Storage::disk('s3')->url($path);
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

}


?>