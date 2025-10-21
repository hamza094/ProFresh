<?php

namespace App\Http\Integrations\Zoom;

use App\Exceptions\Integrations\Zoom\NotFoundException;
use App\Exceptions\Integrations\Zoom\UnauthorizedException;
use App\Exceptions\Integrations\Zoom\ZoomException;
use App\Http\Integrations\Zoom\Requests\GetAccessTokenRequest;
use App\Http\Integrations\Zoom\Requests\GetRefreshTokenRequest;
use Saloon\Helpers\OAuth2\OAuthConfig;
use Saloon\Http\Connector;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\OAuth2\AuthorizationCodeGrant;
use Saloon\Traits\Plugins\AcceptsJson;
use Throwable;

class ZoomConnector extends Connector
{
    use AcceptsJson;
    use AuthorizationCodeGrant;

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
        $clientId = config('services.zoom.client_id')
            ?: env('ZOOM_CLIENT_ID')
            ?: env('ZOOM_TEST_CLIENT_ID');

        $clientSecret = config('services.zoom.client_secret')
            ?: env('ZOOM_CLIENT_SECRET')
            ?: env('ZOOM_TEST_CLIENT_SECRET');

        // Fallback redirect for testing/local without full services config
        $redirect = config('services.zoom.redirect')
            ?: rtrim((string) config('app.url', 'http://localhost:8000'), '/').'/oauth/zoom/callback';

        if (empty($clientId) || empty($clientSecret)) {
            throw new ZoomException('Zoom OAuth client credentials are not configured.');
        }

        return OAuthConfig::make()
            ->setClientId($clientId)
            ->setClientSecret($clientSecret)
            ->setRedirectUri($redirect)
            ->setAuthorizeEndpoint('https://zoom.us/oauth/authorize')
            ->setTokenEndpoint('https://zoom.us/oauth/token')
            ->setDefaultScopes(['user:read:zak',
                'user:read:token',
                'meeting:write:meeting', 'meeting:read:list_meetings',
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
