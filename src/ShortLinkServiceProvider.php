<?php

namespace DivArt\ShortLink;

use Illuminate\Support\ServiceProvider;

class ShortLinkServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . "/src/config/shortlink.php" => config_path('shortlink.php'),
        ]);
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('short_link', function ()
        {
            return new ShortLink;
        });
    }
}