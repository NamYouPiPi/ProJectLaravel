<?php

namespace App\Providers;

use App\View\Components\CreateModal;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //



    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
//        Paginator::useBootstrap(); // for Bootstrap 4/5
        \Blade::component('create_modal',CreateModal::class);

    }
}
