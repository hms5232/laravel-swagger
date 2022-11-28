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
     * Define environment setup for enabling Laravel Swagger,
     * specify which UI version should be used.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function swaggerSpecifyVersion($app)
    {
        $this->enableLS($app);
        $app['config']->set('swagger.ui.ver', '4.15.5');
    }

    /**
     * Define environment setup for enabling Laravel Swagger,
     * custom path of OpenAPI files.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function swaggerCustomFileDomain($app)
    {
        $this->enableLS($app);
        $app['config']->set('swagger.file_url', 'https://laravel-swagger.hhming.moe');
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
        $res = $this->get('/swagger');
        $res->assertStatus(200);
        $res->assertSee('http://localhost/swagger-doc/openapi.yaml');
        $res->assertSee('https://unpkg.com/swagger-ui-dist@4.5.0/swagger-ui-bundle.js');
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

    /**
     * @test
     * @define-env swaggerSpecifyVersion
     */
    public function testSpecifyVersion()
    {
        $res = $this->get('/swagger');
        $res->assertDontSee('https://unpkg.com/swagger-ui-dist@4.5.0/swagger-ui-bundle.js');
        $res->assertSee('https://unpkg.com/swagger-ui-dist@4.15.5/swagger-ui-bundle.js');
    }

    /**
     * @test
     * @define-env swaggerCustomFileDomain
     */
    public function testCustomFileDomain()
    {
        $res = $this->get('/swagger');
        $res->assertDontSee('http://localhost/swagger-doc/openapi.yaml');
        $res->assertSee('https://laravel-swagger.hhming.moe/swagger-doc/openapi.yaml');
    }
}
