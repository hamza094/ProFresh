<?php

namespace App\Http\Integrations\Zoom\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\RateLimitPlugin\Traits\HasRateLimits;
use Saloon\RateLimitPlugin\Contracts\RateLimitStore;
use Saloon\RateLimitPlugin\Stores\LaravelCacheStore;
use Illuminate\Support\Facades\Cache;
use Saloon\RateLimitPlugin\Limit;
use ReflectionClass;

class DeleteMeeting extends Request
{
    use HasRateLimits;

    public function __construct(
       private readonly int $meetingId,
    ) {}

    /**
     * The HTTP method of the request
     */
    protected Method $method = Method::DELETE;

    /**
     * The endpoint for the request
     */
    public function resolveEndpoint(): string
    {
        return '/meetings/'.$this->meetingId;
    }

    /**
     * @return array<int, \Saloon\RateLimitPlugin\Limit>
     */
    protected function resolveLimits(): array
    {
      return [
        Limit::allow(requests: 4)->everySeconds(seconds: 1),
        Limit::allow(6000)->everyDay(),
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
