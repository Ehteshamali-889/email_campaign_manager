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
        // You can register any routes, migrations, or other bootstrapping here
    }
}
