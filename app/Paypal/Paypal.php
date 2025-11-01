<?php

declare(strict_types=1);

namespace App\Paypal;

class Paypal
{
    protected $apiContext;

    public function __construct()
    {

        $this->apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                config('services.paypal.id'),
                config('services.paypal.secret')
            )
        );
    }
}
