<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Laravel Swagger Switch
    |--------------------------------------------------------------------------
    |
    | This option may be used to disable swagger.
    |
    */
    'enable' => env('LARAVEL_SWAGGER_ENABLE', false),

    'ui' => [
        /*
        |--------------------------------------------------------------------------
        | Laravel Swagger Public Path of Swagger UI
        |--------------------------------------------------------------------------
        |
        | This is the URL host the SwaggerUI.
        | Laravel Swagger will be accessible from. Feel free to change this path
        | to anything you like.
        |
        | default is "swagger", this make a route:
        |     <APP_URL>/swagger
        |
        | If set null, Laravel Swagger will disable Swagger UI.
        |
        */
        'path' => env('LARAVEL_SWAGGER_UI_PATH', 'swagger'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Laravel Swagger Public Path Prefix of Files
    |--------------------------------------------------------------------------
    |
    | This is the URL prefix where OpenAPI files storage.
    | Laravel Swagger will be accessible from. Feel free to change this path
    | to anything you like.
    |
    | default is "swagger-doc", this make a route:
    |     <APP_URL>/swagger-doc/<filename|path_to_file>
    |
    */
    'doc_path' => env('LARAVEL_SWAGGER_DOC_PATH', 'swagger-doc'),

    /*
    |--------------------------------------------------------------------------
    | Laravel Swagger Index file
    |--------------------------------------------------------------------------
    |
    | This is the index OpenAPI file that Swagger read first.
    | Edit this depends on your entry point.
    | Accept both JSON and YAML.
    |
    | default is "openapi.yaml", so swagger will request:
    |     <APP_URL>/<doc_path>/openapi.yaml
    | at user visit Swagger UI.
    |
    */
    'index' => env('LARAVEL_SWAGGER_INDEX', 'openapi.yaml'),

    /*
    |--------------------------------------------------------------------------
    | Laravel Swagger Docs File Folder
    |--------------------------------------------------------------------------
    |
    | This is the folder where OpenAPI file storage.
    | The index file should be contained under this folder.
    |
    | default is "storage/swagger", so every OpenAPI documents should put
    | under this folder.
    |
    */
    'folder' => env('LARAVEL_SWAGGER_FOLDER', storage_path('swagger')),

    /*
    |--------------------------------------------------------------------------
    | Laravel Swagger config of Swagger Editor
    |--------------------------------------------------------------------------
    |
    | This is the config of Swagger Editor. Feel free to change those value
    | to anything you like.
    |
    */
    'editor' => [
        /*
         * This will generate a route to swagger editor.
         * If set null, Laravel Swagger will disable Swagger Editor.
         *
         * Default is: <APP_URL>/swagger-editor
         */
        'path' => env('LARAVEL_SWAGGER_EDITOR_PATH', 'swagger-editor'),
    ],
];
