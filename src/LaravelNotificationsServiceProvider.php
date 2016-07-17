<?php

namespace Garf\LaravelNotifications;

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
            __DIR__.'/../config/laravel-notifications.php' => config_path('laravel-notifications.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/../views' => base_path('resources/views/vendor/laravel-notifications'),
        ], 'views');

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
        $this->app->alias('Notifications', \Garf\LaravelNotifications\Notifications::class);
    }

    private function registerLaravelNotifications()
    {
        $this->app->singleton('Notifications', function ($app) {
            return new Notifications();
        });
    }
}
