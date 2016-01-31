<?php

namespace EventHomes\Api\Webhooks;

use Illuminate\Support\ServiceProvider;

class MandrillWebhookServiceProvider extends ServiceProvider
{
    /**
    * Bootstrap the application events.
    *
    * @return void
    */
    public function boot()
    {
        $this->publishes([__DIR__ . '/config/config.php' => config_path('mandrill-webhooks.php')]);
    }

    /**
    * Register the service provider.
    *
    * @return void
    */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/config.php', 'mandrill-webhooks');
    }
}
