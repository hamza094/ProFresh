<?php

namespace App\Interfaces;

use App\DataTransferObjects\Zoom\AccessTokenDetails;
use App\DataTransferObjects\Zoom\AuthorizationCallbackDetails;
use App\DataTransferObjects\Zoom\AuthorizationRedirectDetails;
use App\DataTransferObjects\Zoom\NewMeetingData;
use App\DataTransferObjects\Zoom\UpdateMeetingData;
use App\DataTransferObjects\Zoom\Meeting;
use App\Models\User;

interface Zoom
{
 public function getAuthRedirectDetails(): AuthorizationRedirectDetails;

 public function authorize(
 AuthorizationCallbackDetails $callbackDetails
 ): AccessTokenDetails;

  public function createMeeting(NewMeetingData $meetingData,User $user): Meeting;

public function updateMeeting(array $validated,User $user);

}