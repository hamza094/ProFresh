<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Controllers\Zoom;

use App\Traits\ProjectSetup;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\InteractsWithZoom;

class GetZakTokenTest extends TestCase
{
    use InteractsWithZoom,ProjectSetup,RefreshDatabase;

    /** @test */
    public function successfully_get_zak_token()
    {
        $this->fakeZoom();

        $response = $this->getJson('/api/v1/user/token');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'zak_token',
            ]);
    }
}
