<!--
This file is modified for hms5232/laravel-swagger package.
Make title fit project, and use static link to import js, css, etc.

See more info: https://github.com/hms5232/laravel-swagger
Origin source file: https://swagger.io/docs/open-source-tools/swagger-ui/usage/installation/#unpkg
-->


@php
    $ver = config('swagger.ui.ver') ?? '5.31.0';
    $title = config('swagger.ui.title') ?? config('app.name') . ' - SwaggerUI';
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta
            name="description"
            content="SwaggerUI"
    />
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="https://unpkg.com/swagger-ui-dist{{ '@' . $ver }}/swagger-ui.css" />
</head>
<body>
<div id="swagger-ui"></div>
<script src="https://unpkg.com/swagger-ui-dist{{ '@' . $ver }}/swagger-ui-bundle.js" crossorigin></script>
<script src="https://unpkg.com/swagger-ui-dist{{ '@' . $ver }}/swagger-ui-standalone-preset.js" crossorigin></script>
<script>
    window.onload = () => {
        window.ui = SwaggerUIBundle({
            url: "{{ (config('swagger.file_url') ?? config('app.url')) . '/' . config('swagger.doc_path') . '/' . config('swagger.index') }}",
            dom_id: '#swagger-ui',
            presets: [
                SwaggerUIBundle.presets.apis,
                SwaggerUIStandalonePreset
            ],
            layout: "StandaloneLayout",
        });
    };
</script>
</body>
</html>
