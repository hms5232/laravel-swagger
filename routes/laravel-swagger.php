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
    Route::middleware(config('swagger.middleware', []))->name('swagger.')->group(function () {
        if (config('swagger.ui.path') !== null) {
            // SwaggerUI home page
            Route::view(config('swagger.ui.path'), 'laravel-swagger::ui');
        }

        if (config('swagger.editor.path') !== null) {
            // Since version 5.0.0-alpha.0, Swagger Editor based on Monaco editor
            // The HTML has changed to React based, not compatible with old version (4.x or older)
            Route::view(config('swagger.editor.path'), 'laravel-swagger::editor' . (
                version_compare('5.0.0-alpha.0', config('swagger.editor.ver') ?? '5.0.3') < 1
                    ? '-monaco' // Swagger Editor based on Monaco editor
                    : '' // Swagger Editor based on Ace.js (deprecated by Swagger Editor official)
            ));
        }

        // OpenAPI files
        Route::get(config('swagger.doc_path') . '/{file}', function ($file) {
            return File::get(config('swagger.folder') . '/' . $file);
        })->where('file', '(.*)');
    });
}
