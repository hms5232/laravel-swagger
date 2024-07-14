# laravel-swagger

[![](https://img.shields.io/packagist/v/hms5232/laravel-swagger?include_prereleases)](https://packagist.org/packages/hms5232/laravel-swagger)
![supported PHP version](https://img.shields.io/packagist/dependency-v/hms5232/laravel-swagger/php?logo=php&color=%23787cb4)
![](https://img.shields.io/packagist/dependency-v/hms5232/laravel-swagger/illuminate/support?color=ff2d20&label=Laravel&logo=laravel)
[![](https://img.shields.io/packagist/dt/hms5232/laravel-swagger)](https://packagist.org/packages/hms5232/laravel-swagger)
[![](https://img.shields.io/packagist/l/hms5232/laravel-swagger)](https://github.com/hms5232/laravel-swagger/blob/main/README.md)
[![](https://img.shields.io/github/actions/workflow/status/hms5232/laravel-swagger/phpunit.yml?branch=main&label=test)](https://github.com/hms5232/laravel-swagger/actions?query=branch%3Amain)

Render [OpenAPI](https://www.openapis.org/) JSON or YAML with [SwaggerUI](https://swagger.io/tools/swagger-ui/) in Laravel.

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

If you want to override exists config file, excute command with `--force` flag.

See config file for detail information.

### Manually register

Package support auto-discovery. If you want to control when to register, you can do the following steps:

1. Edit `composer.json` make auto discovery ignore laravel-swagger:
    ```json
    "extra": {
        "laravel": {
            "dont-discover": [
                "hms5232/laravel-swagger"
            ]
        }
    },
    ```

2. Re-generate optimized autoload files:
    ```shell
    composer dump-autoload
    ```

3. Edit `app/Providers/AppServiceProvider.php` define when to register:
    ```php
    use Hms5232\LaravelSwagger\LaravelSwaggerServiceProvider;  // add this
    
    class AppServiceProvider extends ServiceProvider
    {
        public function register()
        {
            // set condition
            // for example, only register when env is "local"
            if ($this->app->environment('local')) {
                $this->app->register(LaravelSwaggerServiceProvider::class);  // register laravel-swagger
            }
        }
    }
    ```

## Why another package

I just want to write a yaml file directly, and use Swagger UI serve/resolve docs.

But exists projects are either using annotations or only supporting JSON (seems like bug, but does not fix.).

So I develop this package, only have a view modified from [Swagger UI (unpkg)](https://swagger.io/docs/open-source-tools/swagger-ui/usage/installation/#unpkg), two routes to link documents.

> This section was written at version [0.1.0](https://github.com/hms5232/laravel-swagger/releases/tag/v0.1.0) and may be outdated in the future.

## LICENSE

[MIT](LICENSE)
