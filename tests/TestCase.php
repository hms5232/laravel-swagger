<?php

namespace Hms5232\LaravelSwagger\Tests;

use Hms5232\LaravelSwagger\LaravelSwaggerServiceProvider;
use Illuminate\Support\Facades\File;
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

    /**
     * Clean up the testing environment before the next test.
     *
     * @return void
     */
    protected function tearDown(): void
    {
        File::delete(config_path('swagger.php'));
        File::deleteDirectory(storage_path('swagger'));
        File::deleteDirectory(storage_path('openapi'));
        parent::tearDown();
    }
}
