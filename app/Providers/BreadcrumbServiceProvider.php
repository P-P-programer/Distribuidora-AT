<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Services\Breadcrumbs;

class BreadcrumbServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(Breadcrumbs::class, fn() => new Breadcrumbs());
    }

    public function boot(): void
    {
        View::composer('*', function ($view) {
            $name = request()->route()?->getName();
            $view->with('breadcrumbs', app(Breadcrumbs::class)->generate($name));
        });
    }
}