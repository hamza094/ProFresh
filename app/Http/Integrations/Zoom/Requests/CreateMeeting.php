<?php

namespace App\Http\Integrations\Zoom\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use App\DataTransferObjects\Zoom\Meeting;
use Saloon\Contracts\Body\HasBody;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;
use DateTime;
use Carbon\Carbon;
use Saloon\RateLimitPlugin\Traits\HasRateLimits;
use Saloon\RateLimitPlugin\Contracts\RateLimitStore;
use Saloon\RateLimitPlugin\Stores\LaravelCacheStore;
use Illuminate\Support\Facades\Cache;
use Saloon\RateLimitPlugin\Limit;
use ReflectionClass;

class CreateMeeting extends Request implements HasBody
{
    use HasJsonBody,HasRateLimits;
    /**
     * The HTTP method of the request
     */
    protected Method $method = Method::POST;

    /**
     * The endpoint for the request
     */
    public function resolveEndpoint(): string
    {
        return '/users/me/meetings';
    }

     public function __construct(
      private readonly array $validated,
    ) {}

      protected function defaultBody(): array
    {
      return [
        'topic'=> $this->validated['topic'],
        'agenda'=> $this->validated['agenda'],
        'duration'=> $this->validated['duration'],
        'password'=> $this->validated['password'],
        'join_before_host'=> $this->validated['join_before_host'],
        'start_time'=> (new DateTime($this->validated['start_time']))->format('Y-m-d\TH:i:s\Z'),
        'timezone'=> $this->validated['timezone'],
    ];
 }
   public function createDtoFromResponse(Response $response): mixed
    {
        return Meeting::fromResponse($response->json());
    }

    protected function resolveLimits(): array
    {
      return [
        Limit::allow(requests: 2)->everySeconds(seconds: 1),
        Limit::allow(2000)->everyDay(),
      ];
    }

    protected function resolveRateLimitStore(): RateLimitStore
    {
       return new LaravelCacheStore(Cache::store(config('cache.default')));
    }

    protected function getLimiterPrefix(): ?string
    {
      return (new ReflectionClass($this))->getShortName()
            .':user_'
          .auth()->id();
    }
}
