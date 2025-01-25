<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserMentioned;
use App\Models\Conversation;
use App\Models\User;
use App\Models\Project;

class MentionedUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_wraps_mentioned_usernames_in_the_body_within_anchor_tag()
    {
      $conversation=Conversation::factory()->create(['user_id'=>1,'message'=>'Hello @johnathan77']);

        $this->assertEquals(
          'Hello <a href="/user/johnathan77/profile" target="_blank">@johnathan77</a>',
          $conversation->message
        );
    }
}
