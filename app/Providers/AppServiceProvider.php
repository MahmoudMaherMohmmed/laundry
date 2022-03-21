<?php

namespace App\Providers;

use App\Models\Post;
use App\Observers\PostObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Config;
use Session;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (array_key_exists('ar', Config::get('languages'))) {
            Session::put('applocale', 'ar');
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultstringLength(191);

        \View::composer("*", function ($view) {
            $view->with("activeStatus", ActiveStatus::class);
            $view->with("conentTypes",  ConentTypes::class);
            $view->with("settingTypes", SettingTypes::class);
        });
    }
}
