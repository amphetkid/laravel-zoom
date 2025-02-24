<?php

namespace Amphetkid\Zoom\Providers;

use Illuminate\Support\ServiceProvider;

class ZoomServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../../config/config.php' => config_path('zoom.php'),
            ], 'config');
        }
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../../config/config.php', 'zoom');
        $this->app->singleton('zoom', 'Amphetkid\Zoom\Zoom');
        $this->app->bind( 'Amphetkid\Zoom\Zoom');
    }
}
