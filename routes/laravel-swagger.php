<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Laravel Swagger Routes
|--------------------------------------------------------------------------
|
| Here is where Laravel Swagger web routes.
|
*/
if (config('swagger.enable')) {
    Route::name('swagger.')->group(function () {
        // SwaggerUI home page
        Route::view(config('swagger.path'), 'laravel-swagger::index');

        // OpenAPI files
        Route::get(config('swagger.prefix') . '/{file}', function($file) {
            return File::get(config('swagger.folder') . '/' . $file);
        })->where('file', '(.*)');
    });
}
