<?php

namespace Hms5232\LaravelSwagger\Tests;

use Illuminate\Support\Facades\File;

class OpenapiConfigTest extends TestCase
{
    /**
     * Copy folders and files under fixtures' directory to specific folder.
     * Default move to storage_path('swagger').
     *
     * @param string|null $to
     * @return void
     */
    protected function copyFixtures(string $to = null)
    {
        File::copyDirectory(__DIR__ . '/fixtures', $to ?? storage_path('swagger'));
    }

    /*
    |--------------------------------------------------------------------------
    | Environment Sets
    |--------------------------------------------------------------------------
    |
    | Define environment sets for test. Don't forget change `enable` in config.
    | You ca use `enableLS($app)` and `disableLS($app)` to change value.
    |
    */

    /**
     * Define environment setup for enabling Laravel Swagger
     * and move openapi file.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function lsDefault($app)
    {
        $this->enableLS($app);
        $this->copyFixtures();
    }

    /*
    |--------------------------------------------------------------------------
    | Tests
    |--------------------------------------------------------------------------
    |
    | Set env at comment by `@define-env {env name}`.
    | Don't forget test both default and custom value.
    |
    */

    /**
     * @test
     * @define-env lsDefault
     */
    public function testDefaultRoute()
    {
        $this->get('/swagger-doc/openapi.yaml')->assertStatus(200);
    }
}
