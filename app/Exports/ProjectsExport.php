<?php

namespace App\Exports;

use App\Models\Project;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;


class ProjectsExport implements FromQuery, WithHeadings , WithMapping
{
  use Exportable;

  public function __construct(Project $project)
  {
      $this->project = $project;
  }

  public function query()
  {
      return Project::query()->where('id',$this->project->id);
  }

  public function headings(): array
{
    return [
        'id',
        'Name',
        'Company',
        'Position',
        'Address',
        'Zipcode',
        'Email',
        'Mobile',
        'Status',
        'Stage',
        'Unqualifed Reason',
        'Created_at'
    ];
}

public function map($project): array
  {
      return [
       $project->id,
       $project->name,
       $project->company,
       $project->position,
       $project->address,
       $project->zipcode,
       $project->email,
       $project->mobile,
       $project->status,
       $project->stage,
       $project->unqualifed,
       $project->created_at->toDateTimeString()

      ];
  }



}
