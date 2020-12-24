<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AppointmentTest extends TestCase
{
  use RefreshDatabase;
  
    /**
     * A appointment unit test.
     *
     * @return void
     */

     /** @test */
     public function it_belongs_to_a_project()
     {
       $this->signIn();
         $appointment = create('App\Appointment');
         $this->assertInstanceOf('App\Project', $appointment->project);
     }
}
