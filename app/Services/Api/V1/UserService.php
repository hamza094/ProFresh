<?php
namespace App\Services\Api\V1;

use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use App\Events\PasswordUpdateEvent;

class UserService
{

  /**
   * @param array<string, mixed> $data
   */
  public function updateUser(User $user, array $data): void
  {
    DB::transaction(function () use ($user, $data) {
        $data = collect($data);
        $userKeys = ['name', 'email', 'username'];

        $user->update($data->only($userKeys)->toArray());

        $user->info?->update($data->except(array_merge($userKeys, ['password', 'current_password']))->toArray());

        if ($data->get('password')) {
          $this->updatePassword($user, $data->get('password'));
        }
    });
  }

  public function updatePassword(User $user, string $password): void
  {
    try {
      $user->password = Hash::make($password);
      $user->save();
      event(new PasswordUpdateEvent($user, now()->toDayDateTimeString()));
    } catch (\Exception $e) {
      throw ValidationException::withMessages([
        'password' => 'Unable to update password. Please try again later.'
      ]);
    }
  }

}
