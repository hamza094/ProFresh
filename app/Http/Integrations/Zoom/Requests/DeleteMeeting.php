<?php

namespace App\Http\Integrations\Zoom\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class DeleteMeeting extends Request
{
       public function __construct(
       private readonly int $meetingId,
    ) {}

    /**
     * The HTTP method of the request
     */
    protected Method $method = Method::DELETE;

    /**
     * The endpoint for the request
     */
    public function resolveEndpoint(): string
    {
        return '/meetings/'.$this->meetingId;
    }
}
