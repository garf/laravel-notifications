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
        $this->publishes([
            __DIR__ . '/../config/laravel-notifications.php' => config_path('laravel-notifications.php')
        ]);

        $this->publishes([
            __DIR__.'/../views' => base_path('resources/views/laravel-notifications'),
        ]);

        $this->loadViewsFrom(__DIR__.'/../views', 'laravel-notifications');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerLaravelNotifications();
        $this->app->alias('Notifications', \Gaaarfild\LaravelNotifications\Notifications::class);
    }

    private function registerLaravelNotifications()
    {
        $this->app->singleton('Notifications', function ($app) {
            return new Notifications();
        });
    }
}
