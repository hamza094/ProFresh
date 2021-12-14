<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Notifications\ProjectTask;
use App\Models\Project;
use App\Models\User;
use Ramsey\Uuid\Uuid;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $users= User::all();
      $projects = Project::all();

      $projects->each(function ($project) use ($users) {

        $project->tasks()->each(function ($task) use ($project) {

          foreach($project->members as $member){
            $member->notifications()->create([
                'id' => Uuid::uuid4()->toString(),
                'type' => ProjectTask::class,
                'data' => [
                    'type' => 'new_task',
                    'reply' => $project->id,
                    'replyable_id' => $project->replyable_id,
                    'replyable_type' => $project->replyable_type,
                    //'replyable_subject' => $project->replyAble()->replyAbleSubject(),
                ],
                'created_at' => $task->created_at,
                'updated_at' => $task->updated_at,
            ]);
          }

        });
      });
    }
}
