<?php 

namespace App\DataTransferObjects\Zoom;

use Carbon\CarbonInterface;
use Carbon\Carbon;

final class Meeting
{
   public function __construct(
   public int $id,
   public string $topic,
   public string $agenda,
   public string $createdAt,
   public int $duration,
   public string $startTime,
   public string $startUrl,
   public string $status,
   public string $timezone,
   public string $password,
   public bool $joinBeforeHost,

 ) {}

   public static function fromResponse(array $response): static
  {
   return new static(
     id: $response['id'],
     topic: $response['topic'],
     agenda: $response['agenda'],
     createdAt: Carbon::parse($response['created_at']),
     duration: $response['duration'],
     startTime: Carbon::parse($response['start_time']),
     startUrl: $response['start_url'],
     status: $response['status'],
     timezone:$response['timezone'],
     password:$response['password'],
     joinBeforeHost:$response['join_before_host'],
 );
}

}