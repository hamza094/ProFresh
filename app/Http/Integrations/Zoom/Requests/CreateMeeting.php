<?php

namespace App\Http\Integrations\Zoom\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use App\DataTransferObjects\Zoom\Meeting;
use Saloon\Contracts\Body\HasBody;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;
use DateTime;
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
      private readonly array $validated,
    ) {}

      protected function defaultBody(): array
    {
      return [
        'topic'=> $this->validated['topic'],
        'agenda'=> $this->validated['agenda'],
        'duration'=> $this->validated['duration'],
        'password'=> $this->validated['password'],
        'join_before_host'=> $this->validated['join_before_host'],
        'start_time'=> (new DateTime($this->validated['start_time']))->format('Y-m-d H:i:s'),
        'timezone'=> $this->validated['timezone'],
    ];
 }
   public function createDtoFromResponse(Response $response): mixed
    {
        return Meeting::fromResponse($response->json());
    }
}
