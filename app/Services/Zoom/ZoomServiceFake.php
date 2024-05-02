<?php

namespace App\Services\Zoom;

//use App\Collections\Spotify\ArtistCollection;
use App\DataTransferObjects\Zoom\AccessTokenDetails;
use App\DataTransferObjects\Zoom\AuthorizationCallbackDetails;
use App\DataTransferObjects\Zoom\AuthorizationRedirectDetails;
use App\Exceptions\Integrations\Zoom\ZoomException;
use App\Interfaces\Zoom;
use App\Models\User;

final class ZoomServiceFake implements Zoom
{
	private ZoomException $failureException;

	public string $authorizationUrl;
    public string $state;
    public string $codeVerifier;

 public function getAuthRedirectDetails(): AuthorizationRedirectDetails
 {
    return new AuthorizationRedirectDetails(
          authorizationUrl: $this->authorizationUrl,
          state: $this->state,
          codeVerifier: $this->codeVerifier,
 );

 }

 public function authorize(
   AuthorizationCallbackDetails $callbackDetails
   ): AccessTokenDetails {

    if (isset($this->failureException)) {
         throw $this->failureException;
    }

    return new AccessTokenDetails(
        accessToken: 'access-token-here',
        refreshToken: 'refresh-token-here',
        expiresAt: now()->addWeek()->toDateTimeImmutable(),
    );
 }

  public function shouldFailWithException(ZoomException $exception): self
 {
      $this->failureException = $exception;
      return $this;
 }


  public function buildAuthorizationUrlUsing(
        string $authorizationUrl,
        string $state,
        string $codeVerifier
    ): self {
        $this->authorizationUrl = $authorizationUrl;
        $this->state = $state;
        $this->codeVerifier = $codeVerifier;
        return $this;
 }

 /*public function getTopArtists(User $user): ArtistCollection
 {
 throw new \Exception('Not implemented');
 }*/

}



