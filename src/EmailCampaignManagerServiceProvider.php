<?php

namespace EmailCampaignManager;

use Illuminate\Support\ServiceProvider;

class EmailCampaignManagerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(EmailCampaignManager::class, function ($app) {
            return new EmailCampaignManager();
        });
    }

    public function boot()
    {
        // Load and optionally publish the routes
        $this->loadRoutesFrom(__DIR__.'/routes/api.php');

        // Load and optionally publish the migrations
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');

        $this->publishes([
            __DIR__.'/database/migrations' => database_path('migrations'),
        ], 'email-campaign-manager-migrations');

        // Load and optionally publish views
        $this->loadViewsFrom(__DIR__.'/resources/views', 'email-campaign-manager');

        $this->publishes([
            __DIR__.'/resources/views' => resource_path('views/vendor/email-campaign-manager'),
        ], 'email-campaign-manager-views');

        // Publish Jobs and Models to app if needed
        $this->publishes([
            __DIR__.'/Jobs' => app_path('Jobs'),
        ], 'email-campaign-manager-jobs');

        $this->publishes([
            __DIR__.'/Models' => app_path('Models'),
        ], 'email-campaign-manager-models');

        // Optional: publish route file if user wants to customize
        $this->publishes([
            __DIR__.'/routes/api.php' => base_path('routes/email-campaign-manager.php'),
        ], 'email-campaign-manager-routes');
    }
}

