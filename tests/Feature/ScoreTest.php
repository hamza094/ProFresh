<?php

namespace Tests\Feature;

use App\LeadScore;
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
    public function score_added_on_lead_avatar_uploaded()
    {
        $this->signIn();
        $lead=create('App\Lead',['avatar_path'=>'img.png']);
        $lead_score = create('App\LeadScore',['lead_id'=>$lead->id,'point'=>15]);
        $this->assertEquals($lead->scores()->sum('point'),15);
    }
}
