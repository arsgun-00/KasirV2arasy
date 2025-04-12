<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        View::composer('admin.template.header', function ($view) {
            $view->with('main', 'Default Main Title'); // Default value for $main
            $view->with('sub', 'Default Subtitle'); // Default value for $sub
        });
    }
}
