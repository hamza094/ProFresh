<?php

namespace App\Exports;

use App\Lead;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;


class LeadsExport implements FromQuery, WithHeadings , WithMapping
{
  use Exportable;

  public function __construct(Lead $lead)
  {
      $this->lead = $lead;
  }

  public function query()
  {
      return Lead::query()->where('id',$this->lead->id);
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

public function map($lead): array
  {
      return [
       $lead->id,
       $lead->name,
       $lead->company,
       $lead->position,
       $lead->address,
       $lead->zipcode,
       $lead->email,
       $lead->mobile,
       $lead->status,
       $lead->stage,
       $lead->unqualifed,
$lead->created_at->toDateTimeString()

      ];
  }



}
