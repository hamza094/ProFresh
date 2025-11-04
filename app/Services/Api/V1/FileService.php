<?php

declare(strict_types=1);

namespace App\Services\Api\V1;

use App\Enums\FileType;
use App\Models\User;
use Exception;
use File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use InvalidArgumentException;
use Spatie\ImageOptimizer\OptimizerChainFactory;

class FileService
{
    // Stores a file in S3 and returns its public URL

    public function store(int|string $id, string $fileInputName, string $fileType): string
    {
        $file = request()->file($fileInputName);

        if (! $file) {
            throw ValidationException::withMessages([
                'file' => 'File not found',
            ]);
        }

        $folderName = $this->getFolderName($fileType);
        $fileName = $this->getGeneratedFileName($id, $file);

        // If the file is an image, optimize it before uploading
        $this->optimizeFile($file);

        return $this->uploadFileToS3($folderName, $file, $fileName);

    }

    /**
     * Deletes the user's avatar file from S3 and clears the avatar_path.
     * Handles both int and string (UUID) user IDs.
     *
     * @throws Exception
     */
    public function deleteFile(User $user): void
    {
        DB::transaction(function () use ($user): void {
            // Use avatar_path if available, fallback to avatar (for legacy)
            $avatarUrl = $user->avatar_path ?? $user->avatar;
            if (! $avatarUrl) {
                return;
            }

            // Extract the S3 file path robustly
            $parsed = parse_url($avatarUrl);
            $filePath = ltrim($parsed['path'] ?? '', '/');
            if ($filePath === '' || $filePath === '0') {
                // If parsing fails, fallback to Str::after
                $filePath = Str::after($avatarUrl, '.com/');
            }

            if ($filePath) {
                Storage::disk('s3')->delete($filePath);
            }

            $user->update(['avatar_path' => null]);
        });
    }

    /* Returns the appropriate folder name for the file type. */
    private function getFolderName(string $fileType): string
    {
        return match ($fileType) {
            FileType::CONVERSATION => 'conversations',
            FileType::AVATAR => 'avatars',
            default => throw new InvalidArgumentException('Invalid file type'),
        };
    }

    /* Generates a unique file name for the file using the project id and file hash. */
    private function getGeneratedFileName(int|string $id, UploadedFile $file): string
    {
        return $id.'_'.$file->hashName();
    }

    private function optimizeFile(UploadedFile $file): void
    {
        if (str_starts_with((string) $file->getMimeType(), 'image/')) {
            OptimizerChainFactory::create()->optimize($file->path());
        }
    }

    private function uploadFileToS3(string $folderName, UploadedFile $file, string $fileName): string
    {
        $s3Disk = Storage::disk('s3');

        try {
            $path = $s3Disk->putFileAs($folderName, $file, $fileName, 'public');
        } catch (Exception $e) {
            throw ValidationException::withMessages(['File upload failed: '.$e->getMessage()]);
        }

        return $s3Disk->url($path);
    }
}
