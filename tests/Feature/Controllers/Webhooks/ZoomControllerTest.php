<?php

namespace Tests\Feature\Controllers\Webhooks;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use App\Models\Meeting;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use Tests\TestCase;

class ZoomControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    protected function setUp(): void
    {
      parent::setUp();

      $this->travelTo(Carbon::parse('2024-06-24 19:36:28'));

    $this->withoutMiddleware([\App\Http\Middleware\VerifyZoomWebhook::class]);

    }
    
    /** @test */
    public function meeting_can_be_updated()
    {
        $meeting=Meeting::factory()->create([
          'meeting_id'=>813,
          'topic'=>'shining in the sky'
        ]);

        $postBody = File::json(
           path: base_path('tests/Fixtures/Webhooks/Zoom/meeting_update.json'),
           flags: JSON_THROW_ON_ERROR,
        );

        $response=$this->post(route('webhooks.meetings.update'),
         $postBody)
            ->assertOk()
            ->assertExactJson(['status' => 'success']);

            $this->assertSame(
               expected: 'eye to eye like sky',
               actual: $meeting->fresh()->topic,
            );

    }

}
