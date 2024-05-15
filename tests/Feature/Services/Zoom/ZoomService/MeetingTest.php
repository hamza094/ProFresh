<?php

namespace Tests\Feature\Services\Zoom\ZoomService;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\DataTransferObjects\Zoom\NewMeetingData;
use App\Exceptions\Integrations\Zoom\ZoomException;
use App\Http\Integrations\Zoom\Requests\CreateMeeting;
use App\Http\Integrations\Zoom\Requests\GetRefreshTokenRequest;
use App\Services\Zoom\ZoomService;
use Saloon\Http\Faking\MockResponse;
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

       $meeting = (new ZoomService())->createMeeting($meetingData,$user);

$this->assertEquals($meeting->meeting_id,124);

        $this->assertEquals($meeting->topic, 'this is fun');

        $this->assertEquals($meeting->agenda, 'the agenda of this meeting should be discussed soon');

        $this->assertEquals($meeting->created_at,'2024-05-16 18:00:07');

        $this->assertEquals($meeting->duration, 30);

        $this->assertEquals($meeting->password, 'hacker');

        $this->assertEquals($meeting->join_before_host, false);

        $this->assertEquals($meeting->start_time, '2024-05-18 18:00:07');

        $this->assertEquals($meeting->start_url, 'https://zoom.us/s/1234567890?pwd=yourpassword');

        $this->assertEquals($meeting->status,'waiting');

        $this->assertEquals($meeting->timezone,'UTC');

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
         'start_time' => (new DateTime('2024-05-18T18:00:07Z'))->format('Y-m-d H:i:s'),
         'timezone' => 'UTC'
    ]);
 
   }

    private function meetingData(){
       return new NewMeetingData(
         topic: 'this is fun', 
         agenda: 'the agenda of this meeting should discussed soon',
         duration: 30,
         password:'hacker',
         joinBeforeHost: false,
         startTime: new DateTime('2024-05-18T18:00:07Z'),
         timezone: 'UTC'
       );        
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

}
