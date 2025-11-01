<?php

declare(strict_types=1);

namespace App\Providers;

use App\Interfaces\Paddle;
use App\Interfaces\SendSmsInterface;
use App\Interfaces\Zoom;
use App\Services\Api\V1\Paddle\SubscriptionService;
use App\Services\Api\V1\PaginationService;
use App\Services\Api\V1\SendSmsService;
use App\Services\Api\V1\Zoom\ZoomService;
use Dedoc\Scramble\Scramble;
use Dedoc\Scramble\Support\Generator\OpenApi;
use Dedoc\Scramble\Support\Generator\SecurityScheme;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Route;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Opcodes\LogViewer\Facades\LogViewer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        JsonResource::withoutWrapping();

        $this->app->bind(
            SendSmsInterface::class,
            SendSmsService::class
        );

        $this->app->bind(Paddle::class, SubscriptionService::class);

        $this->app->bind(Zoom::class, ZoomService::class);

        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Scramble::afterOpenApiGenerated(function (OpenApi $openApi): void {
            $openApi->secure(
                SecurityScheme::http('bearer')
            );
        });

        Scramble::routes(function (Route $route) {
            $excludedPrefixes = [
                'api/v1/admin',
                'api/v1/webhooks',
                'api/v1/oauth/zoom',
                'api/v1/user/token',
                'api/v1/user/jwt/token',
                'api/v1/users/search',
            ];

            return Str::startsWith($route->uri, 'api/v1') &&
               ! Str::startsWith($route->uri, $excludedPrefixes);

        });

        Model::preventLazyLoading(! app()->isProduction());
        // Model::shouldBeStrict(! app()->isProduction());

        /* LogViewer::auth(function ($request) {
        return $request->user()
            && in_array($request->user()->email, [
                'ressie03@example.net',
            ]);
        });*/

        /**
         * Paginate a standard Laravel Collection.
         *
         * @param  int  $perPage
         * @param  int|null  $total
         * @param  int|null  $page
         * @param  string  $pageName
         * @return PaginationService
         */
        Collection::macro('paginate', function ($perPage, $total = null, $page = null, $pageName = 'page') {
            $page = $page ?: PaginationService::resolveCurrentPage($pageName);

            return new PaginationService(
                $this->forPage($page, $perPage)->values(),
                $total ?: $this->count(),
                $perPage,
                $page,
                [
                    'path' => PaginationService::resolveCurrentPath(),
                    'pageName' => $pageName,
                ]
            );
        });
    }
}
