<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Project;
use App\Models\Appointment;
use App\Http\Requests\AppointmentRequest;

class AppointmentTest extends TestCase
{
  use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function setup() :void
    {
        parent::setup();
        $this->user=User::factory()->create();
        $this->loginAs($this->user);
        $this->project=Project::factory()->create([ 'user_id'=>$this->user->id]);
    }

    public function authorized_user_create_appointment()
    {
        $data=[
        'title' => 'Project Discussion',
        'location'=>'Lhr\Pakistan',
        'outcome'=>'Not Intrested',
        'strtdt'=>'11-20-17',
        'strttm'=>'14:05',
        'zone'=>'Asia/pacific'
        ];

        $response=$this->post('api/project/'.$this->project->id.'/appointment',$data);
        $this->assertDatabaseHas('appointments',['title'=>'Project Discussion']);
    }


      public function an_appointment_requires_a_title()
    {
       $appointment=Appointment::factory()->make(['title'=>null,'project_id'=>$this->project->id]);

       $this->withoutExceptionHandling()->post('api/project/'.$this->project->id.'/appointment',
        $appointment->toArray())
            ->assertSessionHasErrors('title');
    }

     public function an_appointment_can_be_updated()
    {
       $data=[
         'title'=>'Project Enhancement',
         'location'=>'Fsl\Pakistan',
         'outcome'=>'Intrested',
         'strtdt'=>'11-20-17',
         'strttm'=>'14:05',
         'zone'=>'Asia/pacific'
    ];

       $user2=User::factory()->create();

       $appointment=Appointment::factory()->create(['project_id'=>$this->project->id]);

       $this->patch('/api/project/'.$this->project->id.'/appointment/'.$appointment->id,$data);

       $appointment->users()->attach($user2);

       $this->assertDatabaseHas('appointments',['id'=>$appointment->id,'zone'=>'Asia/pacific']);
    }

    public function signIn_user_can_delete_appointment()
    {
        $appointment=Appointment::factory()->create(['project_id'=>$this->project->id]);

        $this->delete('/api/project/'.$this->project->id.'/appointment/'.$appointment->id);
        $this->assertDatabaseMissing('appointments',['id'=>$appointment->id]);
    }

}
