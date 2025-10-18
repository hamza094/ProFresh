<?php
declare(strict_types=1);

namespace App\Actions\ProjectMetrics;

use App\Jobs\RecalculateProjectHealth;
use App\Models\Project;
use App\Events\ProjectHealthUpdated;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Log;

final class ProjectHealthRecalculationAction
{
    /**
     * @param array<int,string> $sections
     */
    public function handle(Project $project, array $sections): void
    {
        if (! in_array('health', $sections, true)) {
            return;
        }

        $key = "project:{$project->id}:health-persist";
        $decay = (int) config('project-metrics.health.persist_throttle_seconds', 15 * 60);
        $queue = (string) config('project-metrics.health.persist_queue', 'metrics');
        $dispatched = RateLimiter::attempt(
            $key,
            1,
            function () use ($project, $queue, $key) {
                try {
                    RecalculateProjectHealth::dispatch($project->id, null, true)->onQueue($queue);
                } catch (\Throwable $e) {
                    RateLimiter::clear($key);
                    Log::error('ProjectHealthRecalculationAction: failed to dispatch RecalculateProjectHealth', [
                        'project_id' => $project->id,
                        'exception' => $e,
                    ]);
                }
            },
            $decay
        );

    }
}
