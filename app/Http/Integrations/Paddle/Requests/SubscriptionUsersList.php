<?php

namespace App\Http\Integrations\Paddle\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Contracts\Body\HasBody;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;
use App\DataTransferObjects\Paddle\UserSubscriptionData;
use App\DataTransferObjects\Paddle\Data;
use Saloon\PaginationPlugin\Contracts\Paginatable;

class SubscriptionUsersList extends Request implements HasBody, Paginatable
{
    use HasJsonBody;
    /**
     * The HTTP method of the request
     */
    protected Method $method = Method::POST;

      public function __construct(
       private readonly UserSubscriptionData $UserSubscriptionData,
    ) {}

    /**
     * The endpoint for the request
     */
    public function resolveEndpoint(): string
    {
        return '/users';
    }

    protected function defaultBody(): array
    {
      return [
       'vendor_id' => $this->UserSubscriptionData->vendorID,
       'vendor_auth_code' => $this->UserSubscriptionData->vendorAuthCode,
       'results_per_page' => $this->UserSubscriptionData->resultsPerPage,
       'page'=>1,
    ];
   }    

    public function createDtoFromResponse(Response $response): mixed
    {
       $response->collect()
      ->map(fn (array $data): Data => Data::fromResponse($data));
    }
    
}
