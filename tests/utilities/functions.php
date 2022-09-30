<?php
use App\Models\User;
use App\Models\Project;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\Hash;

function projectSetup(){
  $user=User::factory()->create([
       'email'=>'johndoe@example.org',
       'password'=>Hash::make('testpassword')
   ]);

   Sanctum::actingAs(
       $user,
   );

return Project::factory()->for($user)->create();
}








 ?>
