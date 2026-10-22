<?php

namespace Hms5232\LaravelSwagger\Tests;

use Illuminate\Support\Facades\File;
use Orchestra\Testbench\Attributes\DefineEnvironment;
use PHPUnit\Framework\Attributes\Test;

/**
 * Test for serving OpenAPI files under the docs folder
 */
class DocFileTest extends TestCase
{
    /**
     * Define environment setup for enabling Laravel Swagger,
     * move openapi file and put a file outside the docs folder.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function swaggerWithOutsideFile($app)
    {
        $this->enableLS($app);
        $this->copyFixtures();
        File::put(storage_path('secret.txt'), 'top secret');
    }

    /**
     * Clean up the testing environment before the next test.
     *
     * @return void
     */
    protected function tearDown(): void
    {
        File::delete(storage_path('secret.txt'));
        parent::tearDown();
    }

    #[Test]
    #[DefineEnvironment('swaggerWithOutsideFile')]
    public function testPathTraversal()
    {
        $this->get('/swagger-doc/../secret.txt')->assertStatus(404);
        $this->get('/swagger-doc/..%2Fsecret.txt')->assertStatus(404);
        $this->get('/swagger-doc/..%2F..%2Fstorage%2Fsecret.txt')->assertStatus(404);
        $this->get('/swagger-doc/%2E%2E%2Fsecret.txt')->assertStatus(404);
    }

    #[Test]
    #[DefineEnvironment('swaggerWithOutsideFile')]
    public function testSymlinkOutsideFolder()
    {
        if (!function_exists('symlink') || DIRECTORY_SEPARATOR === '\\') {
            $this->markTestSkipped('Symlink is not available on this platform.');
        }

        symlink(storage_path('secret.txt'), storage_path('swagger/link.txt'));

        $this->get('/swagger-doc/link.txt')->assertStatus(404);
    }

    #[Test]
    #[DefineEnvironment('swaggerWithOutsideFile')]
    public function testFolderWithSamePrefix()
    {
        // "swagger-evil" starts with "swagger" but is not inside the docs folder
        File::copyDirectory(__DIR__ . '/fixtures', storage_path('swagger-evil'));

        try {
            $this->get('/swagger-doc/..%2Fswagger-evil%2Fopenapi.yaml')->assertStatus(404);
        } finally {
            File::deleteDirectory(storage_path('swagger-evil'));
        }
    }

    #[Test]
    #[DefineEnvironment('enableLS')]
    public function testFolderNotExist()
    {
        $this->assertDirectoryDoesNotExist(storage_path('swagger'));
        $this->get('/swagger-doc/openapi.yaml')->assertStatus(404);
    }

    #[Test]
    #[DefineEnvironment('swaggerWithOutsideFile')]
    public function testFileNotExist()
    {
        $this->get('/swagger-doc/not-exist.yaml')->assertStatus(404);
    }

    #[Test]
    #[DefineEnvironment('swaggerWithOutsideFile')]
    public function testDirectory()
    {
        File::makeDirectory(storage_path('swagger/components'));

        $this->get('/swagger-doc/components')->assertStatus(404);
    }

    #[Test]
    #[DefineEnvironment('swaggerWithOutsideFile')]
    public function testFileInSubFolder()
    {
        File::makeDirectory(storage_path('swagger/components'));
        File::copy(storage_path('swagger/openapi.yaml'), storage_path('swagger/components/schemas.yaml'));

        $this->get('/swagger-doc/components/schemas.yaml')->assertStatus(200);
        $this->get('/swagger-doc/components/../openapi.yaml')->assertStatus(200);
    }

    #[Test]
    #[DefineEnvironment('swaggerWithOutsideFile')]
    public function testFileContent()
    {
        $res = $this->get('/swagger-doc/openapi.yaml');
        $res->assertStatus(200);
        $this->assertSame(File::get(storage_path('swagger/openapi.yaml')), $res->getContent());
    }
}
