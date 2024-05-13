<?php

namespace App\Http\Integrations\Zoom;

use Saloon\Helpers\OAuth2\OAuthConfig;
use Saloon\Http\Connector;
use Saloon\Traits\OAuth2\AuthorizationCodeGrant;
use Saloon\Traits\Plugins\AcceptsJson;
use App\Http\Integrations\Zoom\Requests\GetAccessTokenRequest;
use App\Http\Integrations\Zoom\Requests\GetRefreshTokenRequest;
use Saloon\Http\Request;
use App\Exceptions\Integrations\Zoom\ZoomException;
use App\Exceptions\Integrations\Zoom\NotFoundException;
use App\Exceptions\Integrations\Zoom\UnauthorizedException;
use Saloon\Http\Response;
use Throwable;

class ZoomConnector extends Connector
{
    use AuthorizationCodeGrant;
    use AcceptsJson;

    /**
     * The Base URL of the API.
     */
    public function resolveBaseUrl(): string
    {
        return 'https://api.zoom.us/v2/';
    }

    /**
     * The OAuth2 configuration
     */
    protected function defaultOauthConfig(): OAuthConfig
    {
        return OAuthConfig::make()
            ->setClientId(config('services.zoom.client_id'))
            ->setClientSecret(config('services.zoom.client_secret'))
            ->setRedirectUri('http://localhost:8000/oauth/zoom/callback')
            ->setAuthorizeEndpoint('https://zoom.us/oauth/authorize')
            ->setTokenEndpoint('https://zoom.us/oauth/token')
            ->setDefaultScopes(['user:read:zak','meeting:write:meeting','meeting:read:list_meetings',
                'meeting:read:meeting',
                'meeting:delete:meeting',
                'meeting:update:meeting']);
    }

    protected function resolveAccessTokenRequest(
        string $code,
        OAuthConfig $oauthConfig
    ): Request {
    return new GetAccessTokenRequest($code, $oauthConfig);
  }

    protected function resolveRefreshTokenRequest(
        OAuthConfig $oauthConfig,
        string $refreshToken
     ): Request {
          return new GetRefreshTokenRequest($oauthConfig, $refreshToken);
    }

    public function getRequestException(
        Response $response, ?Throwable $senderException
        ): ?Throwable {
         return match ($response->status()) {
            403 => new UnauthorizedException(
            message: $response->body(),
            code: $response->status(),
            previous: $senderException,
        ),
            404 => new NotFoundException(
            message: $response->body(),
            code: $response->status(),
            previous: $senderException,
        ),
        default => new ZoomException(
            message: $response->body(),
            code: $response->status(),
            previous: $senderException,
        ),
    };
  }
}
