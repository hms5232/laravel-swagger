{{--View for Swagger Editor based on Monaco editor--}}

<!--
This file is modified for hms5232/laravel-swagger package.
Make title fit project, and use static link to import js, css, etc.

See more info: https://github.com/hms5232/laravel-swagger
Origin source file: https://swagger.io/docs/open-source-tools/swagger-editor-next/#build-artifacts
-->


@php
    $ver = config('swagger.editor.ver') ?? '5.0.0-alpha.123';
    $title = config('swagger.editor.title') ?? config('app.name') . ' - SwaggerEditor';
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta
        name="description"
        content="SwaggerEditor"
    />
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="https://unpkg.com/swagger-editor{{ '@' . $ver }}/dist/swagger-editor.css" />
</head>
<body>
<div id="swagger-editor"></div>
<script src="https://unpkg.com/react@18/umd/react.production.min.js" crossorigin></script>
<script src="https://unpkg.com/react-dom@18/umd/react-dom.production.min.js" crossorigin></script>
<script src="https://unpkg.com/swagger-editor{{ '@' . $ver }}/dist/umd/swagger-editor.js"></script>
<script>
    const props = {
        url: "{{ (config('swagger.file_url') ?? config('app.url')) . '/' . config('swagger.doc_path') . '/' . config('swagger.index') }}",
    };
    const element = React.createElement(SwaggerEditor, props);
    const domContainer = document.querySelector('#swagger-editor');

    ReactDOM.render(element, domContainer);
</script>
</body>
</html>
