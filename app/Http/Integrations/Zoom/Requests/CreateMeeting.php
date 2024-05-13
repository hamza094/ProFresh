<?php

namespace App\Http\Integrations\Zoom\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use App\DataTransferObjects\Zoom\NewMeetingData;
use App\DataTransferObjects\Zoom\Meeting;
use Saloon\Contracts\Body\HasBody;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;
use Carbon\Carbon;

class CreateMeeting extends Request implements HasBody
{
    use HasJsonBody;
    /**
     * The HTTP method of the request
     */
    protected Method $method = Method::POST;

    /**
     * The endpoint for the request
     */
    public function resolveEndpoint(): string
    {
        return '/users/me/meetings';
    }

     public function __construct(
       private readonly NewMeetingData $newMeetingData,
    ) {}

      protected function defaultBody(): array
    {
      return [
        'topic'=> $this->newMeetingData->topic,
        'agenda'=> $this->newMeetingData->agenda,
        'duration'=> $this->newMeetingData->duration,
        'password'=> $this->newMeetingData->password,
        'join_before_host'=> $this->newMeetingData->joinBeforeHost,
        'start_time'=> $this->newMeetingData->startTime->format('Y-m-d H:i:s'),
        'timezone'=> $this->newMeetingData->timezone,
    ];
 }
   public function createDtoFromResponse(Response $response): mixed
    {
        return Meeting::fromResponse($response->json());
    }
}
