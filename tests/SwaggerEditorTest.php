<?php

namespace Hms5232\LaravelSwagger\Tests;

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
        $this->get('/swagger-editor')->assertStatus(200);
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
}
