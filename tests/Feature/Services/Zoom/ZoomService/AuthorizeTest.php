<?php

namespace Tests\Feature\Services\Zoom\ZoomService;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\DataTransferObjects\Zoom\AuthorizationCallbackDetails;
use App\Http\Integrations\Zoom\Requests\GetAccessTokenRequest;
use App\Services\Zoom\ZoomService;
use PHPUnit\Framework\Attributes\Test;
use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;
use Tests\TestCase;

class AuthorizeTest extends TestCase
{  
    /** @test */
    public function access_details_are_returned(): void
    {
       $this->freezeSecond();

        config([
          'services.zoom.client_id' => 'client-id-here',
          'services.zoom.client_secret' => 'client-secret-here',
        ]);

        Saloon::fake([
           MockResponse::make([
           'access_token' => 'access-token-here',
           'refresh_token' => 'refresh-token-here',
            'expires_in' => 3600,
          ])
        ]);

        $callbackDetails = new AuthorizationCallbackDetails(
            authorizationCode: 'dummy-code',
            expectedState: 'dummy-state',
            state: 'dummy-state',
            codeVerifier: 'dummy-code-verifier',
        );

         $zoomService = new ZoomService();

         $authDetails = $zoomService->authorize($callbackDetails);

         $this->assertEquals('access-token-here', $authDetails->accessToken);

        $this->assertEquals('refresh-token-here', $authDetails->refreshToken);

        $this->assertEquals(
           now()->addHour()->format('U'),
           $authDetails->expiresAt->format('U')
        );

        // Assert our request was sent with the correct code verifier.
        Saloon::assertSent(static function (GetAccessTokenRequest $request): bool {
              return $request->resolveEndpoint() ===
            'https://zoom.us/oauth/token'
            && $request->body()->all() === [
            'grant_type' => 'authorization_code',
            'code' => 'dummy-code',
            'redirect_uri' =>
            'http://127.0.0.1:8000/oauth/zoom/callback',
             'code_verifier' => 'dummy-code-verifier'
        ];
       });
    }
}
