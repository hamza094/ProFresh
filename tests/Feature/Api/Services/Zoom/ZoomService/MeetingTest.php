<?php

namespace Tests\Feature\Api\Services\Zoom\ZoomService;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\DataTransferObjects\Zoom\NewMeetingData;
use App\Exceptions\Integrations\Zoom\ZoomException;
use App\Http\Integrations\Zoom\Requests\CreateMeeting;
use App\Http\Integrations\Zoom\Requests\GetRefreshTokenRequest;
use App\Services\Api\V1\Zoom\ZoomService;
use Saloon\RateLimitPlugin\Exceptions\RateLimitReachedException;
use Saloon\Http\Faking\MockResponse;
use Saloon\Http\PendingRequest;
use Saloon\Enums\Method;
use Saloon\Laravel\Facades\Saloon;
use Tests\TestCase;
use App\Models\User;
use Carbon\Carbon;
use DateTime;

class MeetingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function meeting_can_be_created_in_zoom_if_token_expired(): void
    {
        $this->freezeSecond();

       Saloon::fake([
         GetRefreshTokenRequest::class => MockResponse::make([
          'access_token' => 'new-access-token-here',
          'refresh_token' => 'new-refresh-token-here',
          'expires_in' => 3600,
        ]),
         'users/me/meetings' => $this->mockMeetingResponse(),
       ]);     
        
        $meetingData = $this->meetingData();

        $user = $this->userCreate(now()->subWeek()); 

        $meeting = (new ZoomService())->createMeeting($meetingData,$user);

      Saloon::assertSent(GetRefreshTokenRequest::class);

      $user->refresh();

     $this->assertEquals('new-access-token-here', $user->zoom_access_token);

     $this->assertEquals('new-refresh-token-here', $user->zoom_refresh_token);

     $this->assertTrue(now()->addHour()->equalTo($user->zoom_expires_at)); 
}

    /** @test */
    public function meeting_can_be_created_in_zoom(): void
    {               
      Saloon::fake([
       'users/me/meetings' => $this->mockMeetingResponse(),
      ]);     
        
      $meetingData = $this->meetingData();
  
      $user = $this->userCreate(now()->addWeek()); 

      $this->createAndAssertMeeting($meetingData, $user);

      Saloon::assertNotSent(GetRefreshTokenRequest::class);

      Saloon::assertSent(static fn(CreateMeeting $request): bool =>
        $request->resolveEndpoint() === '/users/me/meetings'
        && $request->getMethod() === Method::POST
        && $request->body()->all() === [
          'topic' => 'this is fun', 
          'agenda' => 'the agenda of this meeting should discussed soon',
           'duration' => 30,
           'password' => 'hacker',
           'join_before_host' => false,
           'start_time' => (new DateTime('2024-06-18T18:00:07Z'))->format('Y-m-d\TH:i:s\Z'),
           'timezone' => 'UTC'
        ]);
   }

     /** @test */
public function rate_limit_is_applied_correctly(): void
{
    $requestCount = 0;

    Saloon::fake([
        'users/me/meetings' => function (PendingRequest $request) use (&$requestCount) {
            $requestCount++;
            if ($requestCount > 2) {
                return MockResponse::make(['error' => 'Rate limit exceeded'], 429);
            }
            return $this->mockMeetingResponse();
        },
    ]);

    $meetingData = $this->meetingData();
    $user = $this->userCreate(now()->addWeek());

    $this->createAndAssertMeeting($meetingData, $user);
    $this->createAndAssertMeeting($meetingData, $user);

    $this->expectException(RateLimitReachedException::class);

    (new ZoomService())->createMeeting($meetingData, $user);
}

    private function meetingData(){
       return [
         'topic' => 'this is fun', 
         'agenda' => 'the agenda of this meeting should discussed soon',
         'duration' => 30,
         'password' =>'hacker',
         'join_before_host' => false,
         'start_time' => (new DateTime('2024-06-18T18:00:07Z'))->format('Y-m-d H:i:s'),
         'timezone' => 'UTC'
       ];        
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

    private function mockMeetingResponse()
    {
      return MockResponse::make([
        'id' => 124,
        'topic' => 'this is fun',
        'agenda' => 'the agenda of this meeting should be discussed soon',
        'created_at'=>'2024-05-16T18:00:07Z',
        'duration' => 30,
        'password' => 'hacker',
        'join_before_host' => false,
        'start_time' => '2024-05-18T18:00:07Z',
        'start_url' => 'https://zoom.us/s/1234567890?pwd=yourpassword',
        'status' => 'waiting',
        'timezone' => 'UTC',
     ]);
  }

  private function createAndAssertMeeting(array $meetingData, User $user): void
{
    $meeting = (new ZoomService())->createMeeting($meetingData, $user);

      $expectedAttributes = [
        'meeting_id' => 124,
        'topic' => 'this is fun',
        'agenda' => 'the agenda of this meeting should be discussed soon',
        'created_at' => '2024-05-16 18:00:07',
        'duration' => 30,
        'password' => 'hacker',
        'join_before_host' => false,
        'start_time' => '2024-05-18 18:00:07',
        'start_url' => 'https://zoom.us/s/1234567890?pwd=yourpassword',
        'status' => 'waiting',
        'timezone' => 'UTC',
    ];

    foreach ($expectedAttributes as $attribute => $value) {
        $this->assertEquals($value, $meeting->$attribute);
    }
}

}
