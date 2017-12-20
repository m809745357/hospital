<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use EasyWeChat\Foundation\Application;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Application $app)
    {
        \View::share('js', $app->js);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
