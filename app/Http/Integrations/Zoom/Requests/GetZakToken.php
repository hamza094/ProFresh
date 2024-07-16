<?php

namespace App\Http\Integrations\Zoom\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Contracts\Authenticator;

class GetZakToken extends Request
{
    
    /**
     * The HTTP method of the request
     */
    protected Method $method = Method::GET;

    public function defaultHeaders(): array
    {
        return [
            'Scopes' => 'user:read:token',
        ];
    }

    /**
     * The endpoint for the request
     */
    public function resolveEndpoint(): string
    {
        return 'users/me/token?type=zak';
    }



}
