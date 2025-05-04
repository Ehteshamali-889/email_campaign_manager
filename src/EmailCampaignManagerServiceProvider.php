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
        $srcPath = __DIR__; // This points to src/
        $basePath = dirname(__DIR__); // This points to the package root

        // Load routes and migrations from src/
        $this->loadRoutesFrom($srcPath.'/routes/api.php');
        $this->loadMigrationsFrom($srcPath.'/database/migrations');

        // Load views from root-level views directory
        $this->loadViewsFrom($basePath.'/views', 'email-campaign-manager');

        // Publish migrations from src/
        $this->publishes([
            $srcPath.'/database/migrations' => database_path('migrations'),
        ], 'email-campaign-manager-migrations');

        // Publish views from root-level views/
        $this->publishes([
            $basePath.'/views' => resource_path('views/vendor/email-campaign-manager'),
        ], 'email-campaign-manager-views');

        // Publish Jobs if present
        if (is_dir($srcPath.'/Jobs')) {
            $this->publishes([
                $srcPath.'/Jobs' => app_path('Jobs'),
            ], 'email-campaign-manager-jobs');
        }

        // Publish Models if present
        if (is_dir($srcPath.'/Models')) {
            $this->publishes([
                $srcPath.'/Models' => app_path('Models'),
            ], 'email-campaign-manager-models');
        }

        // Optionally publish route file to Laravel routes directory
        $this->publishes([
            $srcPath.'/routes/api.php' => base_path('routes/email-campaign-manager.php'),
        ], 'email-campaign-manager-routes');
    }
}

