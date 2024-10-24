<?php

namespace Tests\Feature\Api\V1;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Traits\ProjectSetup;
use App\Services\Api\V1\FileService;
use App\Models\User;
use App\Models\Conversation;
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
      $message='random chat conversation';

      $response=$this->postJson($this->project->path().'/conversations',['message'=>$message,
        'user_id' => $this->user->id]);

        $this->assertDatabaseHas('conversations',[
          'message'=>$message]);
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

      $uploadedFile='conversations/'.$this->project->id.'_'.$file->hashName();

      Storage::disk('s3')->assertExists($uploadedFile);
    }

    /** @test */
    public function allowed_user_can_delete_conversation()
    {
      $conversation=Conversation::factory()->create([
       'project_id'=>$this->project->id,
       'user_id'=>$this->user->id
      ]);

      $response=$this->deleteJson($this->project->path().'/conversations/'.$conversation->id);

      $this->assertModelMissing($conversation);
    }


}
