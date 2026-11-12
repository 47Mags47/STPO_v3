<?php

namespace App\Providers;

use App\Classes\AllResourceRegistrar;
use App\Models\Base\User;
use Illuminate\Routing\PendingResourceRegistration;
use Illuminate\Support\Facades\Gate;
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
        ### ROUTERS
        ##################################################
        Route::macro('allResource', function (string $name, string $controller, array $options = []) {
            /** @var \Illuminate\Routing\Router $this */

            return new PendingResourceRegistration(
                new AllResourceRegistrar($this),
                $name,
                $controller,
                $options
            );
        });


        ### GATES
        ##################################################
        Gate::define('manage-veteran-accesses', function (User $user) {
            // Право назначать права для работы с модулем "Ветеран труда" другим пользователям
            return $user->hasPermission('veteran_admin');
        });
    }
}
