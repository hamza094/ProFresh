<?php

namespace Tests\Feature\Api\Controllers\Zoom;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Exceptions\Integrations\Zoom\ZoomException;
use Tests\Traits\InteractsWithZoom;
use App\Traits\ProjectSetup;
use Tests\TestCase;

class GetZakTokenTest extends TestCase
{
    use RefreshDatabase,InteractsWithZoom,ProjectSetup;

    /** @test */
    public function successfully_get_zak_token()
    {
        $zoomFake = $this->fakeZoom();

        $response=$this->getJson('/api/v1/user/token');

         $response->assertStatus(200)
             ->assertJsonStructure([
                 'zak_token',
             ]);
    }
}
