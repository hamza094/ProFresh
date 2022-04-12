<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;
use App\Services\PaginationService;

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
    }


    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

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
