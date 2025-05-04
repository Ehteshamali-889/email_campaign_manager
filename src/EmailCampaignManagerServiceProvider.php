<?php

namespace EmailCampaignManager;

use Illuminate\Support\ServiceProvider;

class EmailCampaignManagerServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Bind EmailCampaignManager to the service container
        $this->app->singleton(EmailCampaignManager::class, function ($app) {
            return new EmailCampaignManager();
        });
    }

    public function boot()
    {
        // Publish migrations
        $this->publishes([
            __DIR__.'/../database/migrations' => database_path('migrations'),
        ], 'migrations');

        // Publish models (Optional - useful if you want to customize models)
        $this->publishes([
            __DIR__.'/../Models' => app_path('Models'),
        ], 'models');

        // Publish views
        $this->publishes([
            __DIR__.'/../views/emails' => resource_path('views/vendor/email-campaign-manager'),
        ], 'views');

        // Publish routes
        $this->publishes([
            __DIR__.'/../routes/api.php' => base_path('routes/api.php'),
        ], 'routes');

        // Optionally, publish config file if you plan to add configuration options later
        $this->publishes([
            __DIR__.'/../config/email_campaign_manager.php' => config_path('email_campaign_manager.php'),
        ], 'config');
    }
}
