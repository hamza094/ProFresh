<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Interfaces\SendSmsInterface;
use App\Services\SendSmsService;
use Illuminate\Support\Collection;
use App\Services\PaginationService;
use Opcodes\LogViewer\Facades\LogViewer;
use App\Interfaces\Paddle;
use App\Services\Admin\Integration\PaddleService;


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
    }


    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Model::preventLazyLoading(! app()->isProduction());
        Model::shouldBeStrict(! app()->isProduction());

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
         * @param int $total
         * @param int $page
         * @param string $pageName
         * @return array
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
