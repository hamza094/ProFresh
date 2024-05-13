<?php

  namespace App\DataTransferObjects\Zoom;
  use DateTime;
  
  final  class NewMeetingData
  {
    public function __construct(
    public string $topic,
    public string $agenda,
    public int $duration,
    public string $password,
    public bool $joinBeforeHost,
    public DateTime $startTime,
    public string $timezone,
    ) {}
  }