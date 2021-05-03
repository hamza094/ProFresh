<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

class AppointmentTest extends TestCase
{
  use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

     public function setup() :void {
        parent::setup();
        $this->user=factory('App\User')->create();
        $this->signIn($this->user);
      }

     /** @test */
    public function authorized_user_create_appointment()
    {
      $project=create('App\Project',['user_id'=>$this->user->id]);
      $response=$this->post('api/project/'.$project->id.'/appointment',
          ['title' => 'mine hella','location'=>'lhr pakistan','outcome'=>'Not Intrested',
        'strtdt'=>'11-20-17','strttm'=>'14:05','zone'=>'Asia/pacific','outcome'=>'Not intrested']);
        $this->assertDatabaseHas('appointments',['title'=>'mine hella']);
    }

    /** @test */
    public function an_appointment_requires_a_title(){
    $project=create('App\Project',['user_id'=>$this->user->id]);
        $appointment=make('App\Appointment',[
            'title'=>null
        ]);
        $this->post('api/project/'.$project->id.'/appointment',$appointment->toArray())
            ->assertSessionHasErrors('title');
    }

   /** @test */
    public function an_appointment_can_be_updated(){
    $project=create('App\Project',['user_id'=>$this->user->id]);
    $user2=create('App\User');
    $appointment=create('App\Appointment',['project_id'=>$project->id]);
    $this->patch('/api/project/'.$project->id.'/appointment/'.$appointment->id,
    ['title'=>'mine appoint','location'=>'fsl','outcome'=>'Intrested','strtdt'=>'11-20-17','strttm'=>'14:05','zone'=>'Asia/pacific']);
    $appointment->users()->attach($user2);
    $this->assertDatabaseHas('appointments',['id'=>$appointment->id,'zone'=>'Asia/pacific']);
  }

     /** @test */
     public function signIn_user_can_delete_appointment(){
       $project=create('App\Project',['user_id'=>$this->user->id]);
        $appointment=create('App\Appointment',['project_id'=>$project->id]);
        $this->delete('/api/project/'.$project->id.'/appointment/'.$appointment->id);
        $this->assertDatabaseMissing('appointments',['id'=>$appointment->id]);
     }

}
