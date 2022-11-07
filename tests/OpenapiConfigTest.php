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
     * Define environment setup for enabling Laravel Swagger,
     * move openapi file and custom doc_path.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function swaggerCustomDocPath($app)
    {
        $this->enableLS($app);
        $this->copyFixtures();
        $app['config']->set('swagger.doc_path', 'docs');
    }

    /**
     * Define environment setup for enabling Laravel Swagger,
     * move openapi file and custom folder.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function swaggerCustomFolderPath($app)
    {
        $this->enableLS($app);
        $this->copyFixtures(storage_path('openapi'));
        $app['config']->set('swagger.folder', storage_path('openapi'));
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
     * @define-env enableLS
     */
    public function testDefaultRoute()
    {
        $this->copyFixtures();
        $this->get('/swagger-doc/openapi.yaml')->assertStatus(200);
    }

    /**
     * @test
     * @define-env disableLS
     */
    public function testDisable()
    {
        $this->copyFixtures();
        $this->get('/swagger-doc/openapi.yaml')->assertStatus(404);
    }

    /**
     * @test
     * @define-env swaggerCustomDocPath
     */
    public function testCustomDocPath()
    {
        $this->get('/swagger-doc/openapi.yaml')->assertStatus(404);
        $this->get('/docs/openapi.yaml')->assertStatus(200);
    }

    /**
     * @test
     * @define-env swaggerCustomFolderPath
     */
    public function testCustomFolder()
    {
        $this->assertDirectoryDoesNotExist(storage_path('swagger'));
        $this->assertFileDoesNotExist(storage_path('swagger/openapi.yaml'));
        $this->assertDirectoryExists(storage_path('openapi'));
        $this->assertFileExists(storage_path('openapi/openapi.yaml'));
        $this->get('/swagger-doc/openapi.yaml')->assertStatus(200);
    }
}
