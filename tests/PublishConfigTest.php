<?php

namespace Hms5232\LaravelSwagger\Tests;

use Illuminate\Support\Facades\File;

class PublishConfigTest extends TestCase
{
    public function testPublishConfig()
    {
        // 先刪除預設就發布好的設定檔
        File::delete(config_path('swagger.php'));
        $this->assertFileDoesNotExist(config_path('swagger.php'));

        $this->artisan(
            'vendor:publish',
            ['--provider' => 'Hms5232\LaravelSwagger\LaravelSwaggerServiceProvider']
        )->run();
        $this->assertFileExists(config_path('swagger.php'));
    }
}
