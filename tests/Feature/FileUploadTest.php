<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use App\Enums\FileType;
use App\Services\FileService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class FileUploadTest extends TestCase
{
    use RefreshDatabase;

    private $fileService;
    private $fileType;

     public function setUp(): void
    {
        parent::setUp();
        $this->fileService = new FileService();
        $this->fileType = FileType::AVATAR;
    }

     /** @test */
     public function store_method_when_file_missing(): void
     {
        $id = 1;

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('File not found');

        $this->fileService->store($id, 'missing_file', $this->fileType);
    }
}
