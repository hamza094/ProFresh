<?php

namespace App\DataTransferObjects\Zoom;

final class AuthorizationRedirectDetails
{
    public function __construct(
        public string $authorizationUrl,
        public string $state,
        public string $codeVerifier,
    ) {}
}
