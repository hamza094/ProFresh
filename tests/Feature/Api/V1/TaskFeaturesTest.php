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
     * A basic feature test example.
     *
     * @return void
     */

    /** @test */
   public function members_assign_to_task()
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

        $this->assertCount(1, $user->notifications);

        $this->assertDatabaseHas('task_user', [
            'task_id' => $task->id,
            'user_id' => $user->id,
        ]);

        $task->assignee()->attach($user->id);

        $this->assignMembersToTask($task, $members)
              ->assertStatus(422)
              ->assertJsonValidationErrors(['members' => 'One or more users are already assigned to the task.']);
    }

    /** @test */
    public function unassign_a_member_from_a_task()
    {
        $task=$this->project->addTask('test task');

        $task->assignee()->attach($this->user);

        $response= $this->patchJson(route('task.unassign', [
        'project' => $this->project->slug,
        'task' => $task->id,
    ]), ['member' => $this->user->id])
        ->assertSuccessful()
        ->assertJson([
            'message' => 'Task member Unassigned',
        ]);

        $this->assertDatabaseMissing('task_user', [
            'task_id' => $task->id,
            'user_id' => $this->user->id,
        ]);

     $response= $this->patchJson(route('task.unassign', [
        'project' => $this->project->slug,
        'task' => $task->id,
    ]), ['member' => $this->user->id])
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

     $this->project->members()->attach($user);

     $user->members()->updateExistingPivot($this->project,['active'=>true]);

      Sanctum::actingAs(
       $user,
   );

    $this->assertFalse($user->can('taskaccess', $task));    
   }

   /** @test */
   public function auth_user_can_search_project_members()
   { 
      $user = User::factory()->create();

      $task=Task::factory()->create(['project_id'=>$this->project->id]);

      $this->project->members()->attach($user->id, ['active' => true]);

      $searchTerm=$user->username;

     $response = $this->getJson(route('task.members.search',
      ['project' => $this->project->slug,
      'task'=>$task->id]),
    ['search' => $searchTerm])->assertSuccessful();

     $this->assertCount(1, $response->json());
   }

    protected function assignMembersToTask(Task $task, array $members)
   {
    return $this->patchJson(route('task.assign', [
        'project' => $this->project->slug,
        'task' => $task->id,
    ]), ['members' => $members]);
   }

}
