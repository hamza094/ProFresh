<?php

namespace App\Http\Integrations\Zoom\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Contracts\Body\HasBody;
use Saloon\Helpers\OAuth2\OAuthConfig;
use Saloon\Traits\Body\HasFormBody;
use Saloon\Traits\Plugins\AcceptsJson;

class GetAccessTokenRequest extends Request implements HasBody
{
    use HasFormBody;
    use AcceptsJson;

    /**
     * The HTTP method of the request
     */
    protected Method $method = Method::POST;

    public function __construct(
       private string $code,
       private OAuthConfig $oauthConfig,
    ) {
        $this->withBasicAuth(
        $oauthConfig->getClientId(), $oauthConfig->getClientSecret()
    );
 }

    /**
     * The endpoint for the request
     */
    public function resolveEndpoint(): string
    {
        return $this->oauthConfig->getTokenEndpoint();
    }

    public function defaultBody(): array
    {
        return [
          'grant_type' => 'authorization_code',
          'code' => $this->code,
          'redirect_uri' => $this->oauthConfig->getRedirectUri(),
        ];
    }
}