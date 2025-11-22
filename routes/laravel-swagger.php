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
            if (version_compare('5.0.0-alpha.0', config('swagger.editor.ver', '4.5.0')) < 1) {
                // Swagger Editor based on Monaco editor
                Route::view(config('swagger.editor.path'), 'laravel-swagger::editor-monaco');
            } else {
                // Swagger Editor based on Ace.js (deprecated by Swagger Editor official)
                Route::view(config('swagger.editor.path'), 'laravel-swagger::editor');
            }
        }

        // OpenAPI files
        Route::get(config('swagger.doc_path') . '/{file}', function ($file) {
            return File::get(config('swagger.folder') . '/' . $file);
        })->where('file', '(.*)');
    });
}
