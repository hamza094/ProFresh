<?php

namespace App\Actions;

use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DeleteProfileAction
{
    /**
     * Permanently delete users who have been soft deleted for more than 15 days.
     */
    public function execute(): void
    {
        User::onlyTrashed()
            ->where('deleted_at', '<=', now()->subDays(15))
            ->get()
            ->each(fn ($user) => DB::transaction(fn () => $this->handleUserProjects($user)));
    }

    private function handleUserProjects(User $user): void
    {
        $user->projects()->withTrashed()->get()->each(function ($project) use ($user) {
            if ($this->permanentDeleteProject($project)) {
                return;
            }

            $admin = $this->findAdminForProject($project, $user->id);

            if ($admin) {
                $project->user_id = $admin->id;
                $project->save();
            }

            $project->delete();
        });

        $user->forceDelete();
    }

    /**
     * Force delete the project if it has no members.
     *
     * @return bool True if project was deleted, false otherwise.
     */
    private function permanentDeleteProject(Project $project): bool
    {
        if ($project->members()->count() === 0) {
            $project->forceDelete();

            return true;
        }

        return false;
    }

    private function findAdminForProject(Project $project, int $excludeUserId): ?User
    {
        return $project->members()
            ->whereHas('roles', fn ($q) => $q->where('name', 'Admin'))
            ->where('users.id', '!=', $excludeUserId)
            ->first()
            ?? User::role('Admin')->where('id', '!=', $excludeUserId)->first();
    }
}
