<?php

namespace App\Providers;

use App\Services\ComicsService;
use App\Services\Contracts\ComicsServiceContract;
use Illuminate\Support\ServiceProvider;

class ServiceBinderProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(ComicsServiceContract::class, ComicsService::class);
    }
}
