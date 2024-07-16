<?php

namespace App\Actions;

use Firebase\JWT\JWT;

class ZoomAction
{
    protected $sdkKey;
    protected $sdkSecret;

    public function __construct()
    {
        $this->sdkKey = config('services.zoom.client_id');

        $this->sdkSecret = config('services.zoom.client_secret');
    }

    public function handle($meetingNumber, $role)
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

        $jwt = JWT::encode($payload, $this->sdkSecret, 'HS256');

        return $jwt;
      
    }

}



?>
