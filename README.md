# laravel-swagger
Render OpenAPI JSON or YAML with SwaggerUI in Laravel

## Usage

### Installation

```shell
composer require hms5232/laravel-swagger
```

or you want to install only at develop environment:

```shell
composer require hms5232/laravel-swagger --dev
```

### Configure

All configurable items are in `config/swagger.php` after you run publish command:

```shell
php artisan vendor:publish --provider "Hms5232\LaravelSwagger\LaravelSwaggerServiceProvider"
```

See config file for detail information.

## Why another package

I just want to write a yaml file directly, and use Swagger UI serve/resolve docs.

But exists projects are either using annotations or only supporting JSON (seems like bug, but does not fix.).

So I develop this package, only have a view modified from [Swagger UI (unpkg)](https://swagger.io/docs/open-source-tools/swagger-ui/usage/installation/#unpkg), two routes to link documents.

## LICENSE

[MIT](LICENSE)
