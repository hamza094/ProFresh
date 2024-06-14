<?php

namespace Tests\Feature\Services\Zoom\ZoomService;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\DataTransferObjects\Zoom\NewMeetingData;
use App\Exceptions\Integrations\Zoom\ZoomException;
use App\Http\Integrations\Zoom\Requests\DeleteMeeting;
use App\Http\Integrations\Zoom\Requests\GetRefreshTokenRequest;
use App\Services\Zoom\ZoomService;
use Saloon\Http\Faking\MockResponse;
use Saloon\Enums\Method;
use App\Models\User;
use Saloon\Laravel\Facades\Saloon;
use Tests\TestCase;

class MeetingDeleteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function meeting_can_be_deleted_in_zoom()
    {
        $meetingId=12378;

    Saloon::fake([
       '/meetings/'.$meetingId => MockResponse::make(body:'Meeting deleted.',status: 204),
     ]); 
        
        $user = $this->userCreate(now()->addWeek());

        $meeting = (new ZoomService())->deleteMeeting($meetingId,$user);

        Saloon::assertNotSent(GetRefreshTokenRequest::class);

        Saloon::assertSent(static fn(DeleteMeeting $request): bool =>
     $request->resolveEndpoint() === '/meetings/'.$meetingId
     && $request->getMethod() === Method::DELETE);
    }

    private function userCreate($expireAt)
    {
        return User::factory()
            ->create([
              'zoom_access_token' => 'access-token-here',
              'zoom_refresh_token' => 'refresh-token-here',
              'zoom_expires_at' => $expireAt,
        ]);
    }
}
