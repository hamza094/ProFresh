<?php

namespace App\Exports;

use App\Models\Project;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

// use Illuminate\Contracts\Queue\ShouldQueue;

class ProjectsExport implements FromQuery, WithHeadings, WithMapping
{
    public $project;
    use Exportable;

    public function __construct(Project $project)
    {
        $this->project = $project;
    }

    public function query()
    {
        return Project::query()->where('slug', $this->project->slug);
    }

    public function headings(): array
    {
        return [
            'Slug',
            'Name',
            'About',
            'Notes',
            'Stage Updated At',
            'Current Stage',
            'Total Tasks',
            'Total Active Members',
            'Status',
            'Owner Name',
            'Owner Mail Address',
            'Created_at',
        ];
    }

    public function map($project): array
    {
        return [
            $project->slug,
            $project->name,
            $project->about,
            $project->notes,
            $project->stage_updated_at,
            $project->stage->name,
            $project->tasks()->count(),
            $project->activeMembers()->count(),
            $project->currentStatus(),
            $project->user->name,
            $project->user->email,
            $project->created_at->toDateTimeString(),

        ];
    }
}
