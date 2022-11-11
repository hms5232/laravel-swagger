<?php

namespace Hms5232\LaravelSwagger\Tests;

use Illuminate\Support\Facades\File;

class SwaggerUiTest extends TestCase
{
    /**
     * Define environment setup for enabling Laravel Swagger
     * and custom path of Swagger UI.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function swaggerCustomUiPath($app)
    {
        $this->enableLS($app);
        $app['config']->set('swagger.ui.path', 'my-swagger-ui');
    }

    /**
     * Define environment setup for enabling Laravel Swagger
     * but null path for Swagger UI.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function swaggerNullUiPath($app)
    {
        $this->enableLS($app);
        $app['config']->set('swagger.ui.path', null);
    }

    /**
     * Define environment setup for enabling Laravel Swagger,
     * move openapi file and custom index of openapi file.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function swaggerCustomIndexFile($app)
    {
        $this->enableLS($app);
        $this->copyFixtures();
        $app['config']->set('swagger.index', 'index.yaml');
        File::move(storage_path('swagger/openapi.yaml'), storage_path('swagger/index.yaml'));
    }

    /**
     * @test
     * @define-env disableLS
     */
    public function testDisable()
    {
        $this->get('/swagger')->assertStatus(404);
    }

    /**
     * @test
     * @define-env enableLS
     */
    public function testDefaultRoute()
    {
        $this->get('/swagger')->assertStatus(200);
    }

    /**
     * @test
     * @define-env swaggerCustomUiPath
     */
    public function testCustomRoute()
    {
        $this->get('/swagger')->assertStatus(404);
        $this->get('/my-swagger-ui')->assertStatus(200);
    }

    /**
     * @test
     * @define-env swaggerNullUiPath
     */
    public function testNullPath()
    {
        $this->get('/swagger')->assertStatus(404);
    }

    /**
     * @test
     * @define-env swaggerCustomIndexFile
     */
    public function testCustomIndexFile()
    {
        $this->assertFileDoesNotExist(storage_path('swagger/openapi.yaml'));
        $this->get('/swagger-doc/index.yaml')->assertStatus(200);
        $this->get('/swagger')->assertDontSee('Failed to load API definition.');
    }
}
