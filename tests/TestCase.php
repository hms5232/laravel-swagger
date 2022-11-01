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
}
