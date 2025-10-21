<?php

namespace App\DataTransferObjects\Paddle;

final class UserSubscriptionData
{
    public function __construct(
        public int $vendorID,
        public string $vendorAuthCode,
        public int $resultsPerPage,
    ) {}
}
