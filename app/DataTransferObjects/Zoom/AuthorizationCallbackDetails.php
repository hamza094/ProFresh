<?php
namespace App\DataTransferObjects\Zoom;

final class AuthorizationCallbackDetails
{
 public function __construct(
 public string $authorizationCode,
 public string $expectedState,
 public string $state,
 public string $codeVerifier,
 ) {}
}
