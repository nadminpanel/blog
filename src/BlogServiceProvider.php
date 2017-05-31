<?php

namespace NAdminPanel\Blog;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use NAdminPanel\AdminPanel\Middleware\AdminMiddleware;
use NAdminPanel\AdminPanel\Models\Permission;
use NAdminPanel\AdminPanel\Models\PermissionLabel;
use NAdminPanel\AdminPanel\Models\Role;

class BlogServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/migrations');
        $this->loadViewsFrom(__DIR__.'/views', 'nap-blog');
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadPublishes();
    }

    public function register()
    {
        $this->registerProviders();
    }


    private function registerProviders()
    {
        $this->app->register('Unisharp\Laravelfilemanager\LaravelFilemanagerServiceProvider');
    }

    private function loadPublishes()
    {
        $this->publishes([
            __DIR__ . '/public' => public_path(),
            __DIR__ . '/seeds/CategoryPermissionSeeder.php.slug' => database_path('seeds/CategoryPermissionSeeder.php')
        ]);
    }
}