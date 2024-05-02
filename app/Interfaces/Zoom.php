<?php

namespace App\Interfaces;

use App\DataTransferObjects\Zoom\AccessTokenDetails;
use App\DataTransferObjects\Zoom\AuthorizationCallbackDetails;
use App\DataTransferObjects\Zoom\AuthorizationRedirectDetails;
use App\Models\User;

interface Zoom
{
 public function getAuthRedirectDetails(): AuthorizationRedirectDetails;

 public function authorize(
 AuthorizationCallbackDetails $callbackDetails
 ): AccessTokenDetails;


}