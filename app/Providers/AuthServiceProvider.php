<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Task;
use Illuminate\Validation\Rules\Password;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        'App\Models\Project' => 'App\Policies\ProjectsPolicy',
        'App\Models\User' => 'App\Policies\UsersPolicy',
        'App\Models\Task' => 'App\Policies\TasksPolicy',

    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Password::defaults(
            fn () =>
        Password::min(8)
            ->letters()
             ->mixedCase()
            ->numbers()
            ->symbols()
        );

        Gate::before(function ($user, $ability) {
            return $user->hasRole('Admin') ? true : null;
        });


        Gate::define('archive-task', function ($user, Task $task) {
            return $task->trashed()
            ? throw ValidationException::withMessages(['task' => 'Task is archived. Activate the task to proceed.']) : true;
        });


        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new MailMessage())
                ->subject('Verify Email Address')
                ->line('Click the button below to verify your email address.This link will expire after 60 minutes.Please Remember you must be login to get your account verified')
                ->action('Verify Email Address', $url);
        });

        VerifyEmail::$createUrlCallback = function ($notifiable) {
            return URL::temporarySignedRoute(
                'verification.verify',
                Carbon::now()->addMinutes(60),
                [
                    'user' => $notifiable->uuid,
                    'hash' => sha1($notifiable->getEmailForVerification()),
                ]
            );
        };

    }
}
