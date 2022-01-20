<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Appointment;
use App\Models\Project;
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


     public function it_belongs_to_a_project()
     {
          $this->login();
         $appointment =Appointment::factory()->create();
         $this->assertInstanceOf(Project::class, $appointment->project);
     }
}
