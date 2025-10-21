<?php

namespace App\DataTransferObjects\Zoom;

use DateTimeImmutable;

final class AccessTokenDetails
{
    public function __construct(
        public string $accessToken,
        public string $refreshToken,
        public DateTimeImmutable $expiresAt,
    ) {}
}
