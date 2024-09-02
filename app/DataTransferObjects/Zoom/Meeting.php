<?php 

namespace App\DataTransferObjects\Zoom;
use Auth;
use Carbon\CarbonInterface;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;
use DateTime;

final class Meeting 
{
   public function __construct(
   public int $meeting_id,
   public string $topic,
   public string $agenda,
   public string $created_at,
   public int $duration,
   public string $start_time,
   public string $start_url,
   public string $join_url,
   public string $status,
   public string $timezone,
   public string $password,
   public bool $join_before_host,

 ) {}

   public static function fromResponse(array $response): static
  {
   return new static(
     meeting_id: $response['id'],
     topic: $response['topic'],
     agenda: $response['agenda'],
     created_at: Carbon::parse($response['created_at']),
     duration: $response['duration'],
     start_time: Carbon::parse($response['start_time']),
     start_url: $response['start_url'],
     join_url: $response['start_url'],
     status: $response['status'],
     timezone:$response['timezone'],
     password:$response['password'],
     join_before_host:$response['join_before_host'] ?? false,
 );
}

}