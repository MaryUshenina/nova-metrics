<?php

namespace Square1\NovaMetrics;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;

class CardServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->booted(function () {
            $this->routes();
        });

        Nova::serving(function (ServingNova $event) {
            Nova::script('CustomTrend', __DIR__.'/../dist/js/card.js');
            Nova::style('CustomTrend', __DIR__.'/../dist/css/card.css');

            Nova::script('CustomValue', __DIR__.'/../dist/js/card.js');
            Nova::style('CustomValue', __DIR__.'/../dist/css/card.css');

            Nova::script('CustomPartition', __DIR__.'/../dist/js/card.js');
            Nova::style('CustomPartition', __DIR__.'/../dist/css/card.css');

            Nova::script('CustomPartitionValue', __DIR__.'/../dist/js/card.js');
            Nova::style('CustomPartitionValue', __DIR__.'/../dist/css/card.css');
        });
    }

    /**
     * Register the card's routes.
     *
     * @return void
     */
    protected function routes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        Route::middleware(['nova'])
                ->prefix('nova-vendor/CustomTrend')
                ->group(__DIR__.'/../routes/api.php');

        Route::middleware(['nova'])
                ->prefix('nova-vendor/CustomValue')
                ->group(__DIR__.'/../routes/api.php');

        Route::middleware(['nova'])
                ->prefix('nova-vendor/CustomPartition')
                ->group(__DIR__.'/../routes/api.php');

        Route::middleware(['nova'])
                ->prefix('nova-vendor/CustomPartitionValue')
                ->group(__DIR__.'/../routes/api.php');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
