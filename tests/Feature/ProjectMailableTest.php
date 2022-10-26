<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Project;
use App\Models\Message;
use App\Models\User;
use App\Mail\ProjectMail;

use Tests\TestCase;

class ProjectMailableTest extends TestCase
{
  use RefreshDatabase;

     /** @test */
     public function project_message_maialable_content()
     {
       $project=Project::factory()
       ->has(Message::factory(['type'=>'mail'])->count(1))->create();

       $mail=$project->messages->take(1);

       $mail[0]->subject='this is mail subject';

       $mail[0]->save();

       $mailable = new ProjectMail($project,$mail[0]);

       $mailable
       ->assertSeeInHtml($mail[0]->subject)
       ->assertSeeInHtml($mail[0]->message)
       ->assertSeeInHtml($project->name);
     }
}
