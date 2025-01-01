<?php

namespace App\Providers;

use App\Interfaces\Zoom;
use App\Services\Api\V1\Zoom\ZoomService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Interfaces\SendSmsInterface;
use App\Services\Api\V1\SendSmsService;
use Illuminate\Support\Collection;
use App\Services\Api\V1\PaginationService;
use Opcodes\LogViewer\Facades\LogViewer;
use App\Interfaces\Paddle;
use App\Services\Api\V1\Admin\Integration\PaddleService;
use Dedoc\Scramble\Scramble;
use Dedoc\Scramble\Support\Generator\OpenApi;
use Dedoc\Scramble\Support\Generator\SecurityScheme;
use Illuminate\Routing\Route;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Response;


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

       $this->app->bind(
         abstract: Paddle::class,
         concrete: fn (): Paddle => new PaddleService()
        );

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
      Scramble::afterOpenApiGenerated(function (OpenApi $openApi) {
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
        'api/v1/user/activities',
        'api/v1/data',
        'api/v1/tasksdata',
        'api/v1/user/projects',
        'api/v1/users/search',
    ];

    return Str::startsWith($route->uri, 'api/v1') && 
       !Str::startsWith($route->uri, $excludedPrefixes);

});


        Model::preventLazyLoading(! app()->isProduction());
        //Model::shouldBeStrict(! app()->isProduction());

        /* LogViewer::auth(function ($request) {
        return $request->user()
            && in_array($request->user()->email, [
                'ressie03@example.net',
            ]); 
        });*/


         /**
     * Paginate a standard Laravel Collection.
     *
     * @param int $perPage
     * @param int|null $total
     * @param int|null $page
     * @param string $pageName
     * @return \App\Services\Api\V1\PaginationService
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
