<?php

namespace App\Providers;

use Dedoc\Scramble\Scramble;
use Dedoc\Scramble\Support\Generator\OpenApi;
use Dedoc\Scramble\Support\Generator\SecurityScheme;
use Illuminate\Routing\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Scramble::afterOpenApiGenerated(function (OpenApi $openApi) {
            /** @var SecurityScheme $scheme */
            $scheme = SecurityScheme::http('bearer', 'sanctum');
            $openApi->secure($scheme);

            $openApi->info->title = 'Soft-line API';
            $openApi->info->description = 'Documentação da API de clientes e produtos para o teste técnico da Soft-line.';
            $openApi->info->version = '0.1';
        });

        Scramble::routes(function (Route $route) {
            return Str::startsWith($route->uri, 'api/');
        });
    }
}
