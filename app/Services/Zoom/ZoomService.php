<?php

namespace App\Services\Zoom;

use App\DataTransferObjects\Zoom\AccessTokenDetails;
use App\DataTransferObjects\Zoom\AuthorizationCallbackDetails;
use App\DataTransferObjects\Zoom\AuthorizationRedirectDetails;
use App\DataTransferObjects\Zoom\NewMeetingData;
use App\DataTransferObjects\Zoom\Meeting;
use App\Exceptions\Integrations\Zoom\ZoomException;
use App\Http\Integrations\Zoom\ZoomConnector;
use App\Http\Integrations\Zoom\Requests\GetAccessTokenRequest;
use App\Http\Integrations\Zoom\Requests\CreateMeeting;
use App\Interfaces\Zoom;
use App\Models\User;
use Illuminate\Support\Str;
use Saloon\Http\Auth\AccessTokenAuthenticator;

final class ZoomService implements Zoom
{

 public function getAuthRedirectDetails(): AuthorizationRedirectDetails
 {
     $codeVerifier = Str::random(random_int(43, 128));

     $codeChallenge = hash('sha256', $codeVerifier, true);

     $codeChallenge = strtr(base64_encode($codeChallenge), '+/', '-_');

     $codeChallenge = trim($codeChallenge, '=');

     $connector = $this->connector();

     $authorizationUrl = $connector->getAuthorizationUrl(
    scopeSeparator: ',',
     additionalQueryParameters: [
       'code_challenge' => $codeChallenge,
       'code_challenge_method' => 'S256',
    ]
  );

    return new AuthorizationRedirectDetails(
       authorizationUrl: $authorizationUrl,
       state: $connector->getState(),
       codeVerifier: $codeVerifier,
    );

 }

 public function authorize(
 AuthorizationCallbackDetails $callbackDetails
 ): AccessTokenDetails {

     $tokenDetails = $this->connector()->getAccessToken(
        code: $callbackDetails->authorizationCode,
        state: $callbackDetails->state,
        expectedState: $callbackDetails->expectedState,
        requestModifier: function (
          GetAccessTokenRequest $saloonRequest
        ) use ($callbackDetails) {
         $saloonRequest->body()->add(
         'code_verifier',
          $callbackDetails->codeVerifier,
        );
    }
  );

     return new AccessTokenDetails(
       accessToken: $tokenDetails->accessToken,
       refreshToken: $tokenDetails->refreshToken,
       expiresAt: $tokenDetails->expiresAt,
    );
     
}

   private function connector(): ZoomConnector
   {
     return new ZoomConnector();
   }

    private function connectorForUser(User $user): ZoomConnector
    {
       $accessTokenDetails = $this->getZoomOAuthDetails($user);

        $connector = $this->connector()->authenticate($accessTokenDetails);

        if ($accessTokenDetails->hasExpired()) {

        $newAccessTokenDetails =
            
         $connector->refreshAccessToken($accessTokenDetails);

         $connector->authenticate($newAccessTokenDetails);

         $this->updateZoomOAuthDetails($newAccessTokenDetails, $user);
        }

         return $connector;
    }

    private function getZoomOAuthDetails(User $user): AccessTokenAuthenticator
   {
     return new AccessTokenAuthenticator(
         $user->zoom_access_token,
         $user->zoom_refresh_token,
         $user->zoom_expires_at->toDateTimeImmutable(),
    );
 }

    private function updateZoomOAuthDetails(
       AccessTokenAuthenticator $newAccessTokenDetails,
       User $user
        ): void {
          $user->updateZoomOAuthDetails(
           $newAccessTokenDetails->getAccessToken(),
           $newAccessTokenDetails->getRefreshToken(),
           $newAccessTokenDetails->getExpiresAt(),
        );
    }

    public function createMeeting(NewMeetingData $meetingData,User $user): Meeting
   {
     if (!$user->isConnectedToZoom()) 
     {
       throw new ZoomException('User is not connected to Zoom.');
     }

    return $this->connectorForUser($user)
       ->send(new CreateMeeting($meetingData))
       ->dtoOrFail();
   }

}

