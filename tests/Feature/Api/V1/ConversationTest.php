<?php

namespace Tests\Feature\Api\V1;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Traits\ProjectSetup;
use App\Events\NewMessage;
use Illuminate\Support\Facades\Event;
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
    public function allowed_user_can_see_project_conversations()
    {
      $conversation=Conversation::factory()->create(['project_id'=>$this->project->id,
    ]);

      $response=$this->withoutExceptionHandling()->getJson($this->project->path().'/conversations');

      $response->assertJsonFragment([
        'message' => $conversation->message,
      ]);
    }

    /** @test */
    public function allowed_user_participates_in_project_chat()
    {
      Event::fake();

      $message='random chat conversation';

      $response=$this->withoutExceptionHandling()->postJson($this->project->path().'/conversations',['message'=>$message,
        'user_id' => $this->user->id]);

        $this->assertDatabaseHas('conversations',[
          'message'=>$message]);

      Event::assertDispatched(NewMessage::class);
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

      $file=UploadedFile::fake()->image('file.jpg')->size(700);

      $response=$this->postJson($this->project->path().'/conversations',[
        'message'=>'abra ka dabra',
        'file'=>$file,
        'user_id' => $this->user->id]);

      $uploadedFile='conversations/'.$this->project->id.'_'.$file->hashName();

      Storage::disk('s3')->assertExists($uploadedFile);
    }

    /** @test */
    public function allowed_user_can_delete_conversation()
    {
      Storage::fake('s3');

      $conversation=Conversation::factory()->create([
       'project_id'=>$this->project->id,
       'user_id'=>$this->user->id,
       'file'=>UploadedFile::fake()->image('photo1.jpg'),
      ]);

      $response=$this->deleteJson($this->project->path().'/conversations/'.$conversation->id);

      $this->assertModelMissing($conversation);

      Storage::disk('s3')->assertMissing('photo1.jpg');
    }


}
