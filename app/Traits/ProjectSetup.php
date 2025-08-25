<?php
namespace App\Traits;

use App\Models\User;
use App\Models\Project;
use App\Models\TaskStatus;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\Hash;

trait ProjectSetup
{

   public $project;
   public $user;
   public $status;

   protected function setUp(): void{

      parent::setUp();

       $this->user=User::factory()->create([
       'email'=>'johndoe@example.org',
       'password'=>Hash::make('testpassword')
   ]);

   Sanctum::actingAs(
       $this->user,
   );

   $this->status = TaskStatus::factory()->create();

   $this->project = Project::factory()->for($this->user)->create();

    //if ($this instanceof \Tests\Feature\TaskTest) {
            //$this->status = TaskStatus::factory()->create();
        //}

   $middlewaresToRemove = [
            \App\Http\Middleware\CheckSubscription::class,
        ];

   $this->withoutMiddleware($middlewaresToRemove);
   }
}
