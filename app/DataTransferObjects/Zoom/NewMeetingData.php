<?php

  namespace App\DataTransferObjects\Zoom;
  use WendellAdriel\ValidatedDTO\ValidatedDTO;

  use DateTime;
  
  final class NewMeetingData extends ValidatedDTO 
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

    protected function rules(): array
    {
        return [
          'topic'=>['required','integer','max:200'],
          'agenda'=>['required','string','max:2000'],
          'duration'=>['required','integer'],
          'password'=>['required','string','max:10'],
          'joinBeforeHost'=>['required','boolean'],
          'startTime'=>['required','after:now'],
          'timezone'=>['required','timezone:all'],
        ];
    }

    protected function defaults(): array
    {
        return [];
    }

    protected function casts(): array
    {
        return [];
    }
  }