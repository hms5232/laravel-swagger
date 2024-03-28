<?php

namespace Hms5232\LaravelSwagger\Tests;

use Illuminate\Support\Facades\File;
use Orchestra\Testbench\Attributes\DefineEnvironment;
use PHPUnit\Framework\Attributes\Test;

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
     * Define environment setup for enabling Laravel Swagger,
     * specify which Editor version should be used.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function swaggerSpecifyVersion($app)
    {
        $this->enableLS($app);
        $app['config']->set('swagger.editor.ver', '4.6.0');
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

    #[Test]
    #[DefineEnvironment('disableLS')]
    public function testDisable()
    {
        $this->get('/swagger-editor')->assertStatus(404);
    }

    #[Test]
    #[DefineEnvironment('enableLS')]
    public function testDefaultRoute()
    {
        $res = $this->get('/swagger-editor');
        $res->assertStatus(200);
        $res->assertSee('http://localhost/swagger-doc/openapi.yaml');
        $res->assertSee('https://unpkg.com/swagger-editor-dist@4.5.0/swagger-editor-bundle.js');
    }

    #[Test]
    #[DefineEnvironment('swaggerCustomEditorPath')]
    public function testCustomRoute()
    {
        $this->get('/swagger-editor')->assertStatus(404);
        $this->get('/my-swagger-editor')->assertStatus(200);
    }

    #[Test]
    #[DefineEnvironment('swaggerNullEditorPath')]
    public function testNullPath()
    {
        $this->get('/swagger-editor')->assertStatus(404);
    }

    #[Test]
    #[DefineEnvironment('swaggerCustomIndexFile')]
    public function testCustomIndexFile()
    {
        $this->assertFileDoesNotExist(storage_path('swagger/openapi.yaml'));
        $this->get('/swagger-doc/index.yaml')->assertStatus(200);

        $res = $this->get('/swagger-editor');
        $res->assertDontSee('Failed to load API definition.');
        $res->assertSee('http://localhost/swagger-doc/index.yaml');
    }

    #[Test]
    #[DefineEnvironment('swaggerSpecifyVersion')]
    public function testSpecifyVersion()
    {
        $res = $this->get('/swagger-editor');
        $res->assertDontSee('https://unpkg.com/swagger-editor-dist@4.5.0/swagger-editor-bundle.js');
        $res->assertSee('https://unpkg.com/swagger-editor-dist@4.6.0/swagger-editor-bundle.js');
    }

    #[Test]
    #[DefineEnvironment('swaggerCustomFileDomain')]
    public function testCustomFileDomain()
    {
        $res = $this->get('/swagger-editor');
        $res->assertDontSee('http://localhost/swagger-doc/openapi.yaml');
        $res->assertSee('https://laravel-swagger.hhming.moe/swagger-doc/openapi.yaml');
    }
}
