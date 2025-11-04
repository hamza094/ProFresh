<?php

declare(strict_types=1);

namespace App\Actions;

use Firebase\JWT\JWT;

class ZoomAction
{
    protected string $sdkKey;

    protected string $sdkSecret;

    public function __construct()
    {
        $this->sdkKey = config('services.zoom.client_id');
        $this->sdkSecret = config('services.zoom.client_secret');
    }

    /**
     * @param  int|string  $meetingNumber
     */
    public function handle($meetingNumber, int $role): string
    {
        $iat = time() - 30;
        $exp = $iat + 60 * 60 * 2;

        $payload = [
            'sdkKey' => $this->sdkKey,
            'appKey' => $this->sdkKey,
            'mn' => $meetingNumber,
            'role' => $role,
            'iat' => $iat,
            'exp' => $exp,
            'tokenExp' => $exp,
        ];

        return JWT::encode($payload, $this->sdkSecret, 'HS256');
    }
}
