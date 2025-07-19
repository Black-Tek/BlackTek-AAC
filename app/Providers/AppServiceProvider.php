<?php

namespace App\Providers;

use App\Services\VocationService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->registerSingleton(VocationService::class, 'vocations');
    }

    /**
     * Register a singleton with an alias in one line
     */
    private function registerSingleton(string $class, string $alias): void
    {
        $this->app->singleton($class);
        $this->app->alias($class, $alias);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
