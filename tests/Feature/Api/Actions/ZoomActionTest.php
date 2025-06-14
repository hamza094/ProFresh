<?php

namespace Tests\Feature\Api\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Config;
use App\Actions\ZoomAction;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Tests\TestCase;

class ZoomActionTest extends TestCase
{
    protected $sdkKey;
    protected $sdkSecret;
    protected $action;

    protected function setUp(): void
    {
        parent::setUp();

        Config::set('services.zoom.client_id', 'fake-key');

        Config::set('services.zoom.client_secret', 'fake-secret');

        $this->sdkKey = config('services.zoom.client_id');

        $this->sdkSecret = config('services.zoom.client_secret');

        $this->action = new ZoomAction($this->sdkKey, $this->sdkSecret);
    }

    /** @test */
    public function it_generates_a_valid_jwt_token()
    {
        $meetingNumber = 1234567890;
        $role = 1;

        $token = $this->action->handle($meetingNumber, $role);

            $decodedToken = JWT::decode($token, new Key($this->sdkSecret, 'HS256'));

            $this->assertEquals($this->sdkKey, $decodedToken->sdkKey);
            $this->assertEquals($meetingNumber, $decodedToken->mn);
            $this->assertEquals($role, $decodedToken->role);
    }
}
