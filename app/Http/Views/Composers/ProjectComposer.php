<?php

namespace App\Http\View\Composers;

use App\Models\User;
use Illuminate\View\View;

class ProjectComposer
{
    protected ?User $user = null;

    /**
     * Create a new profile composer.
     */
    public function __construct()
    {
        // Resolve the currently authenticated user (if any)
        $this->user = auth()->user();
    }

    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $lastSeen = $this->user?->lastseen ?? null;
        $view->with('lastSeen', $lastSeen);
    }
}
