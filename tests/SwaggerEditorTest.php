<?php

namespace Hms5232\LaravelSwagger\Tests;

use Illuminate\Support\Facades\File;

class SwaggerEditorTest extends TestCase
{
    /**
     * Define environment setup for enabling Laravel Swagger
     * and custom path of Swagger Editor.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function swaggerCustomEditorPath($app)
    {
        $this->enableLS($app);
        $app['config']->set('swagger.editor.path', 'my-swagger-editor');
    }

    /**
     * Define environment setup for enabling Laravel Swagger
     * but null path for Swagger Editor.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function swaggerNullEditorPath($app)
    {
        $this->enableLS($app);
        $app['config']->set('swagger.editor.path', null);
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
        $this->get('/swagger-editor')->assertStatus(404);
    }

    /**
     * @test
     * @define-env enableLS
     */
    public function testDefaultRoute()
    {
        $res = $this->get('/swagger-editor');
        $res->assertStatus(200);
        $res->assertSee('http://localhost/swagger-doc/openapi.yaml');
    }

    /**
     * @test
     * @define-env swaggerCustomEditorPath
     */
    public function testCustomRoute()
    {
        $this->get('/swagger-editor')->assertStatus(404);
        $this->get('/my-swagger-editor')->assertStatus(200);
    }

    /**
     * @test
     * @define-env swaggerNullEditorPath
     */
    public function testNullPath()
    {
        $this->get('/swagger-editor')->assertStatus(404);
    }

    /**
     * @test
     * @define-env swaggerCustomIndexFile
     */
    public function testCustomIndexFile()
    {
        $this->assertFileDoesNotExist(storage_path('swagger/openapi.yaml'));
        $this->get('/swagger-doc/index.yaml')->assertStatus(200);

        $res = $this->get('/swagger-editor');
        $res->assertDontSee('Failed to load API definition.');
        $res->assertSee('http://localhost/swagger-doc/index.yaml');
    }
}
