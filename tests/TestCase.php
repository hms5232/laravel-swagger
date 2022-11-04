<?php

namespace Hms5232\LaravelSwagger\Tests;

use Hms5232\LaravelSwagger\LaravelSwaggerServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array<int, string>
     */
    protected function getPackageProviders($app)
    {
        return [
            LaravelSwaggerServiceProvider::class,
        ];
    }

    /**
     * Define environment setup for disabling Laravel Swagger.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function disableLS($app)
    {
        $app['config']->set('swagger.enable', false);
    }

    /**
     * Define environment setup for enabling Laravel Swagger.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function enableLS($app)
    {
        $app['config']->set('swagger.enable', true);
    }
}
