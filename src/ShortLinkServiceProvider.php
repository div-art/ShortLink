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
        //
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

        $this->registerPublishables();
    }

    public function registerPublishables()
    {
        $basePath = dirname(__DIR__);

        $arrPublishable = [
            'config' => [
                $basePath . "/src/config/shortlink.php" => config_path('shortlink.php'),
            ]
        ];

        foreach ($arrPublishable as $group => $paths) {
            $this->publishes($paths, $group);
        }
    }
}