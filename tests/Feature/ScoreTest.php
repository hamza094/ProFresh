<?php

namespace Tests\Feature;

use App\ProjectScore;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ScoreTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    /** @test */
    public function get_sum_of_project_score_on_performing_project_related_activity()
    {
        $this->signIn();
        $project=create('App\Project',['avatar_path'=>'img.png']);
        $project->addScore('Avatar Uploaded',15);
        $task=$project->addTask('test task');
        $project->addScore('Task Added',10);
        $appointment=create('App\Appointment',['project_id'=>$project->id]);
        $project->addScore('Appointment Added',10);
        $this->assertEquals($project->scores()->sum('point'),35);
    }

}
