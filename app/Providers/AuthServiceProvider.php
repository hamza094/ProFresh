<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Task;
use Illuminate\Validation\ValidationException;


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

    Gate::define('archive-task', function ($user, Task $task) {
    return $task->trashed()
        ? throw ValidationException::withMessages(['task' => 'Task is archived. Activate the task to proceed.'])
        : true;
      });
}
}