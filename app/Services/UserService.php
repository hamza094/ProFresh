<?php
namespace App\Services;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Mail\PasswordUpdate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;

class UserService
{

  public function updateUser(User $user, array $data): void
  {    
    $userKeys = ['name', 'email', 'username'];

    $password = $data['password'] ?? null;

    unset($data['password'], $data['current_password']);

    $user->update(Arr::only($data, $userKeys));

     if ($user->info) {
       $user->info->update(Arr::except($data, $userKeys));
    }

    if ($password) {
      $this->updatePassword($user, $password);
    }
  }

  public function updatePassword(User $user,$password): void
  {
    try {
          $user->password = Hash::make($password);
          $user->save();
          $this->sendPasswordUpdateEmail($user);
        } catch (\Exception $e) {
          throw ValidationException::withMessages([
            'password' => 'Unable to update password. Please try again later.'
        ]);
    } 
  }

    private function sendPasswordUpdateEmail(User $user): void
    {
      $time=now()->toDayDateTimeString();
      Mail::to($user)->send(new PasswordUpdate($time));
    } 

  /**
   * Show paypal plan.
   *
   * @param  int  $user 
  */
  /*public function showPaypalPlan($user)
  {
    return $data=[
      'intent' => $user->createSetupIntent(),
      'plans'=> $this->availablePlans()
    ];
   }*/

  /**
   * Get paypal plans.
   * 
  */
  /*protected function availablePlans()
  {
   return $availablePlans=[
    'price_1IJejOLbPiqgp3U5jzTsYjVW' =>'Monthly',
    'price_1IJepYLbPiqgp3U5mqEuYgQr' =>'Yearly',
    ];
   }*/

}

?>
