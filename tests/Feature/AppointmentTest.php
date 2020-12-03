<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AppointmentTest extends TestCase
{
  use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

     /** @test */
    public function signIn_user_create_appointment()
    {
      $this->signIn();
      $project=create('App\Project');
      $response=$this->post('api/projects/'.$project->id.'/appointment',
          ['title' => 'mine hella','location'=>'lhr pakistan','outcome'=>'Not Intrested',
        'strtdt'=>'11-20-17','strttm'=>'14:05','zone'=>'Asia/pacific','outcome'=>'Not intrested']);
        $this->assertDatabaseHas('appointments',['title'=>'mine hella']);
    }

    /** @test */
    public function an_appointment_requires_a_title(){
        $this->signIn();
        $project=create('App\Project');
        $appointment=make('App\Appointment',[
            'title'=>null
        ]);
        $this->post('api/projects/'.$project->id.'/appointment',$appointment->toArray())
            ->assertSessionHasErrors('title');

    }

   /** @test */
    public function an_appointment_can_be_updated(){
    $this->signIn();
    $project=create('App\Project');
    $user=create('App\User');
    $appointment=create('App\Appointment',['project_id'=>$project->id]);
    $title= 'mine mella';
    $location='fsl pakistan';
    $outcome='Intrested';
    $strtdt='11-20-17';
    $strttm='14:05';
    $zone='Asia/pacific';
    $outcome='Not intrested';
    $this->patch('/api/projects/'.$project->id.'/appointment/'.$project->id,
    ['title'=>$title,'location'=>$location,'outcome'=>$outcome,'strtdt'=>$strtdt,'strttm'=>$strttm,'zone'=>$zone,'outcome'=>$outcome]);
    $appointment->users()->attach($user);
    $this->assertDatabaseHas('appointments',['id'=>$appointment->id,'zone'=>$zone]);
  }


     /** @test */
     public function signIn_user_can_delete_appointment(){
        $this->signIn();
        $project=create('App\Project');
        $appointment=create('App\Appointment',['project_id'=>$project->id]);
        $this->delete('/api/projects/'.$project->id.'/appointment/'.$project->id);
        $this->assertDatabaseMissing('appointments',['id'=>$appointment->id]);
     }


}
