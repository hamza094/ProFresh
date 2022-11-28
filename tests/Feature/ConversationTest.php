<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Traits\ProjectSetup;
use App\Models\Group;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ConversationTest extends TestCase
{
    use RefreshDatabase,ProjectSetup;

    /** @test */
    public function allowed_user_participates_in_project_chat()
    {
      $response=$this->postJson($this->project->path().'/conversations',['message'=>'random chat conversation',
        'user_id' => $this->user->id]);

        $this->assertDatabaseHas('conversations',[
          'message'=>'random chat conversation']);
    }

    /** @test */
    public function chat_validation_check()
    {
      $response=$this->postJson($this->project->path().'/conversations',['message'=>null,
        'user_id' => $this->user->id]);

      $response->assertJsonValidationErrors('message');
    }

    /** @test */
    public function allowed_user_store_file_in_chat()
    {
      Storage::fake('s3');

      $file=UploadedFile::fake()->image('file.jpg');

      $response=$this->postJson($this->project->path().'/conversations',['file'=>$file,
        'user_id' => $this->user->id])->assertOk();

      /*Storage::disk('s3')->assertExists('/storage/'.$file->hashName());*/
    }


}
