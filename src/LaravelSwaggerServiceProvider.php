<?php

namespace Hms5232\LaravelSwagger;

use Illuminate\Support\ServiceProvider;

class LaravelSwaggerServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/swagger.php',
            'swagger'
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/swagger.php' => config_path('swagger.php'),
        ]);

        $this->loadRoutesFrom(__DIR__ . '/../routes/laravel-swagger.php');

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'laravel-swagger');
    }
}
