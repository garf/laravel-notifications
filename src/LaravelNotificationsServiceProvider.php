<?php

namespace Gaaarfild\LaravelNotifications;

use Illuminate\Support\ServiceProvider;

class LaravelNotificationsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerLaravelNotifications();
        $this->app->alias('conf', \Gaaarfild\LaravelNotifications\Notifications::class);
    }

    private function registerLaravelNotifications()
    {
        $this->app->bindShared('Notifications', function ($app) {
            return new Notifications();
        });
    }
}
