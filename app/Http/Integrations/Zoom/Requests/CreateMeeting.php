<?php

namespace App\Http\Integrations\Zoom\Requests;

use App\DataTransferObjects\Zoom\Meeting;
use DateTime;
use Illuminate\Support\Facades\Cache;
use ReflectionClass;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\RateLimitPlugin\Contracts\RateLimitStore;
use Saloon\RateLimitPlugin\Limit;
use Saloon\RateLimitPlugin\Stores\LaravelCacheStore;
use Saloon\RateLimitPlugin\Traits\HasRateLimits;
use Saloon\Traits\Body\HasJsonBody;

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

    /**
     * @param  array<string, mixed>  $validated
     */
    public function __construct(
        private readonly array $validated,
    ) {}

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return [
            'topic' => $this->validated['topic'],
            'agenda' => $this->validated['agenda'],
            'duration' => $this->validated['duration'],
            'password' => $this->validated['password'],
            'join_before_host' => $this->validated['join_before_host'],
            'start_time' => (new DateTime($this->validated['start_time']))->format('Y-m-d\TH:i:s\Z'),
            'timezone' => $this->validated['timezone'],
        ];
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return Meeting::fromResponse($response->json());
    }

    /**
     * @return array<int, Limit>
     */
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
