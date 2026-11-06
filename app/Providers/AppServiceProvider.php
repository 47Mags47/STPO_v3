<?php

namespace App\Providers;

use App\Classes\AllResourceRegistrar;
use Illuminate\Routing\PendingResourceRegistration;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

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
        Route::macro('allResource', function (string $name, string $controller, array $options = []) {
            return new PendingResourceRegistration(
                new AllResourceRegistrar($this),
                $name,
                $controller,
                $options
            );
        });
    }
}
