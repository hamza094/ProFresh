<?php

namespace Tests\Feature\Controllers\OAuth\ZoomController;

use App\Models\User;
use App\Exceptions\Integrations\Zoom\ZoomException;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Tests\Traits\InteractsWithZoom;
use App\Traits\ProjectSetup;

class CallbackTest extends TestCase
{
    use LazilyRefreshDatabase;
    use InteractsWithZoom;
    use ProjectSetup;

    /** @test */
    public function user_can_complete_connection_to_zoom(): void
    {
        $this->freezeSecond();

        $this->fakeZoom();

        session()->put('oauth_zoom_state', 'dummy-state');

        session()->put('oauth_zoom_code_verifier', 'dummy-code-verifier');

        $response = $this->getJson(route('oauth.zoom.callback') . '?code=dummy-code&state=dummy-state');

       $response->assertJson([
        'success' => 'Zoom account connected successfully',
    ]);

     $this->user->refresh();

     $this->assertEquals('access-token-here', $this->user->zoom_access_token);

     $this->assertEquals('refresh-token-here', $this->user->zoom_refresh_token);

     $this->assertTrue(now()->addWeek()->equalTo($this->user->zoom_expires_at));

    }

    /** @test */
    public function error_is_returned_if_the_authorization_fails(): void
    {
       $this->fakeZoom()->shouldFailWithException(
           new ZoomException(),
        );

        session()->put('oauth_zoom_state', 'dummy-state');

        session()->put('oauth_zoom_code_verifier', 'dummy-code-verifier');

     $response = $this->getJson(route('oauth.zoom.callback') . '?code=dummy-code&state=dummy-state');

        $response->assertJson([
        'error' => 'Failed to connect to Zoom account',
    ]);
        $this->assertUserWasNotUpdated($this->user->fresh());
    }

    private function assertUserWasNotUpdated(User $user): void
    {
        $this->assertNull($user->zoom_access_token);
        $this->assertNull($user->zoom_refresh_token);
        $this->assertNull($user->zoom_expires_at);
    }


    /** @test */
    public function error_is_returned_if_the_code_is_missing_from_the_request()
    {
      $this->fakeZoom();

       session()->put('oauth_zoom_state', 'dummy-state');

        session()->put('oauth_zoom_code_verifier', 'dummy-code-verifier');

     $response = $this->getJson(route('oauth.zoom.callback') . '?state=dummy-state')->assertBadRequest();

      $this->assertUserWasNotUpdated($this->user);
 }

}
