<?php

namespace App\Http\Integrations\Zoom\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Contracts\Body\HasBody;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;
use DateTime;
use Carbon\Carbon;

class UpdateMeeting extends Request implements HasBody
{
    use HasJsonBody;
    /**
     * The HTTP method of the request
     */
    protected Method $method = Method::PATCH;

     public function __construct(
       private readonly array $validated,
    ) {}

    /**
     * The endpoint for the request
     */
    public function resolveEndpoint(): string
    {
        return '/meetings/'.$this->validated['meeting_id'];
    }

      protected function defaultBody(): array
    {
      return array_filter([
            'topic' => $this->validated['topic'] ?? null,
            'agenda' => $this->validated['agenda'] ?? null,
            'duration' => $this->validated['duration'] ?? null,
            'start_time' => isset($this->validated['start_time']) ? (new DateTime($this->validated['start_time']))->format('Y-m-d\TH:i:s\Z') : null,
            'password' => $this->validated['password'] ?? null,
            'join_before_host' => $this->validated['join_before_host'] ?? null,
            'timezone' => $this->validated['timezone'] ?? null,
        ], function ($value) {
            return !is_null($value);
        });
 }
}
