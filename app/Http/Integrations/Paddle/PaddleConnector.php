<?php

namespace App\Http\Integrations\Paddle;

use Saloon\Http\Connector;
use Saloon\Http\Request;
use Saloon\Traits\Plugins\AcceptsJson;
use Saloon\Http\Response;

class PaddleConnector extends Connector
{
    use AcceptsJson;

    /**
     * The Base URL of the API
     */
    public function resolveBaseUrl(): string
    {
        return 'https://sandbox-vendors.paddle.com/api/2.0/subscription/';
    }

    /**
     * Default headers for every request
     */
    protected function defaultHeaders(): array
    {
        return [];
    }

    /**
     * Default HTTP client options
     */
    protected function defaultConfig(): array
    {
        return [];
    }

}
