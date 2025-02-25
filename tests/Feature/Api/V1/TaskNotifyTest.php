<?php

namespace Tests\Feature\Api\V1;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Actions\TaskDueAction;
use Mockery;
use Carbon\Carbon;
use Mockery\MockInterface;
use App\Traits\ProjectSetup;
use App\Enums\TaskDueNotifies;
use App\Console\Commands\TaskNotify;
use App\Notifications\TaskDue;
use Illuminate\Support\Facades\Notification;
use App\Models\User;
use Tests\TestCase;

class TaskNotifyTest extends TestCase
{
    use RefreshDatabase,ProjectSetup;

    /** @test */
    public function test_task_notify_command_handles_notifications()
    {
        Notification::fake();

        $status=TaskStatus::factory()->create();

        $user=User::factory()->create();

        $task=Task::factory()->create([
            'notified' => '1 Day Before',
            'due_at' => now()->addDay(),
            'status_id' => $status->id,
        ]);

        $task->assignee()->attach($user);
        
        $this->artisan('tasks:notify')
        ->expectsOutput('Task notifications sent successfully.')
        ->assertSuccessful();
    
       Notification::assertSentTo($user,TaskDue::class);

       $this->assertEquals($task->fresh()->notify_sent,1);
    }


}
