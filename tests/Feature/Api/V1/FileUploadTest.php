<?php

namespace Tests\Feature\Api\V1;

use App\Enums\FileType;
use App\Services\Api\V1\FileService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class FileUploadTest extends TestCase
{
    use RefreshDatabase;

    private $fileService;

    private $fileType;

    protected function setUp(): void
    {
        parent::setUp();
        $this->fileService = new FileService;
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
