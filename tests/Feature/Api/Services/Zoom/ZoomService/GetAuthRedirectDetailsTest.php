<?php

namespace Tests\Feature\Api\Services\Zoom\ZoomService;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\Api\V1\Zoom\ZoomService;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetAuthRedirectDetailsTest extends TestCase
{
    /** @test */
    public function auth_redirect_details_can_be_returned(): void
    {
        Str::createRandomStringsUsing(static fn(): string => 'random-string-here');

        config([
          'services.zoom.client_id' => 'client-id-here',
        ]);

        $authDetails = (new ZoomService())->getAuthRedirectDetails();

        // Get the query parameters from the authorization URL.
        $queryParameters = [];
          parse_str(
          parse_url(
            $authDetails->authorizationUrl, PHP_URL_QUERY
        ),
           $queryParameters,
        );

        // Assert the authorization URL has the expected query parameters.
        $this->assertCount(7, $queryParameters);
        
        $this->assertEquals(
           '6XubkmX33mCpz3mcaXhGHtsewBFJsCQPCW5bff_tDac',
            $queryParameters['code_challenge']
        );

        $this->assertEquals('S256', $queryParameters['code_challenge_method']);

        // Assert the state and code challenge are both returned.
        $this->assertEquals($queryParameters['state'], $authDetails->state);

       $this->assertEquals('random-string-here', $authDetails->codeVerifier);
    }
}
