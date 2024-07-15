<?php

namespace App\Providers;

use Illuminate\Foundation\Providers\FoundationServiceProvider as ServiceProvider;
use Illuminate\Foundation\MaintenanceModeManager;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Foundation\MaintenanceMode;

class FoundationServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(MaintenanceMode::class, function ($app) {
            return new MaintenanceModeManager($app);
        });
    }
}
