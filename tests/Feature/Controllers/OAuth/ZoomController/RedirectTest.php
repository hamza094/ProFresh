<?php

namespace Tests\Feature\Controllers\OAuth\ZoomController;

use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\Test;
use Tests\Traits\InteractsWithZoom;
use App\Traits\ProjectSetup;
use App\Models\User;
use Tests\TestCase;

class RedirectTest extends TestCase
{
     use LazilyRefreshDatabase;
     use InteractsWithZoom;
     use ProjectSetup;

    /** @test */
    public function user_is_redirected_to_zoom(): void
    {
        $this->fakeZoom()->buildAuthorizationUrlUsing(
          authorizationUrl: 'https://dummy-redirect-url.com',
          state: 'dummy-state',
          codeVerifier: 'dummy-code-verifier',
        );

        $response = $this->get(route('oauth.zoom.redirect'));

         // Retrieve the cached values from the cache
        $oauthZoomState = session()->get('oauth_zoom_state');

        $oauthZoomCodeVerifier = session()->get('oauth_zoom_code_verifier');

         $this->assertEquals('dummy-state', $oauthZoomState);
         $this->assertEquals('dummy-code-verifier', $oauthZoomCodeVerifier);
    }
}
