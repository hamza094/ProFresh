<?php

namespace Tests\Feature\Api\V1;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Traits\ProjectSetup;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use App\Models\User;
use App\Models\Task;

class TaskFeaturesTest extends TestCase
{
      use RefreshDatabase,ProjectSetup;
    /**
     * Feature test.
     *
     * @return void
     */

    /** @test */
   public function members_assign_to_task_and_pervent_duplication()
   {
      $task=$this->project->addTask('test task');

      $user=User::factory()->create();
      
      $members = [$user->id];

     $user->members()->syncWithoutDetaching([
        $this->project->id => ['active' => true]]);

      $this->assignMembersToTask($task, $members)
            ->assertSuccessful()
            ->assertJson([
              'message' => 'Task assigned to member Successfully',
            ]);

        $this->assertDatabaseHas('task_user', [
            'task_id' => $task->id,
            'user_id' => $user->id,
        ]);

        $this->assertCount(1, $user->notifications);

        // Attempt to reassign the same member to the task
        $this->assignMembersToTask($task, $members)
              ->assertStatus(422)
              ->assertJsonValidationErrors(['members' => 'One or more users are already assigned to the task.']);
        }

    /** @test */
    public function it_unassigns_a_member_from_a_task_and_handles_invalid_requests()
    {
        $task=$this->project->addTask('test task');
        $task->assignee()->attach($this->user);

        $this->unassignMemberFromTask($task, $this->user->id)
        ->assertSuccessful()
        ->assertJson(['message' => 'Task member Unassigned']);

        $this->assertDatabaseMissing('task_user', [
            'task_id' => $task->id,
            'user_id' => $this->user->id,
        ]);

       $this->unassignMemberFromTask($task, $this->user->id)
        ->assertStatus(422)
        ->assertJsonValidationErrors(['member' => 'The selected user is not a current member of task.']);
    }

      /** @test */   
   public function allowed_user_can_archive_and_unarchive_task()
   {
      $task = Task::factory()->for($this->project)->create();

      $this->deleteJson(route('task.archive', [
        'project' => $this->project->slug,
        'task' => $task->id
    ]));

      $this->assertSoftDeleted($task);

     $this->getJson(route('task.unarchive', [
        'project' => $this->project->slug,
        'task' => $task->id,
      ]));

      $this->assertNotSoftDeleted($task);
   }

     /** @test */
   public function project_members_does_not_perform_task_operations()
   {
     $task=Task::factory()->for($this->project)->create();

     $user=User::factory()->create();

     $this->project->activeMembers()->attach($user);

      Sanctum::actingAs(
       $user,
   );

    $this->assertFalse($user->can('taskaccess', $task));    
   }

   /** @test */
   public function auth_user_can_search_project_members()
   { 
      $user = User::factory()->create(['name' => 'test_user']);

      $task=Task::factory()->create(['project_id'=>$this->project->id]);

      $this->project->members()->attach($user->id, ['active' => true]);

     $response = $this->getJson(route('task.members.search',[
        'project' => $this->project->slug,
      'task'=>$task->id
  ]),['search' => 'test'])
        ->assertSuccessful();

     $this->assertCount(1, $response->json());
   }

    /** @test */
   public function allowed_user_can_remove_archived_task_from_database()
   {
     $task = Task::factory()->for($this->project)->create();

    $this->deleteJson(route('task.archive', [
        'project' => $this->project->slug,
        'task' => $task->id
    ]));

    $this->assertSoftDeleted($task);

    $this->deleteJson(route('task.remove', [
        'project' => $this->project->slug,
        'task' => $task->id
    ]));

    $this->assertModelMissing($task);

   }

    protected function assignMembersToTask(Task $task, array $members)
   {
    return $this->patchJson(route('task.assign', [
        'project' => $this->project->slug,
        'task' => $task->id,
    ]), ['members' => $members]);
   }


  protected function unassignMemberFromTask(Task $task, int $memberId)
  {
    return $this->patchJson(route('task.unassign', [
        'project' => $this->project->slug,
        'task' => $task->id,
    ]), ['member' => $memberId]);
  }

}
