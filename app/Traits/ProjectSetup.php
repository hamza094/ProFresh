<?php
namespace App\Traits;
use App\Models\User;
use App\Models\Project;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\Hash;

trait ProjectSetup
{

   public $project;
   public $user;

   protected function setUp(): void{

      parent::setUp();

       $this->user=User::factory()->create([
       'email'=>'johndoe@example.org',
       'password'=>Hash::make('testpassword')
   ]);

   Sanctum::actingAs(
       $this->user,
   );

   $this->project = Project::factory()->for($this->user)->create();

   $middlewaresToRemove = [
            \App\Http\Middleware\CheckSubscription::class,
        ];

   $this->withoutMiddleware($middlewaresToRemove);
   }
}
