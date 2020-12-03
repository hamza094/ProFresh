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
    public function score_added_on_project_avatar_uploaded()
    {
        $this->signIn();
        $project=create('App\Project',['avatar_path'=>'img.png']);
        $project_score = create('App\ProjectScore',['project_id'=>$project->id,'point'=>15]);
        $this->assertEquals($project->scores()->sum('point'),15);
    }
}
