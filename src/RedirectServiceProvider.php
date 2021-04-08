<?php

namespace MasterDmx\LaravelManagedRedirect;

use Illuminate\Support\ServiceProvider;

class RedirectServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([ __DIR__.'/../migrations' => database_path('migrations')], 'migrations');
    }

    public function register()
    {
        $this->app->singleton(RedirectManager::class);
    }
}
