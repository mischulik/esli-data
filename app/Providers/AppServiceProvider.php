<?php

namespace App\Providers;

use App\Actions\ElsieServiceStateAction;
use App\Models\Product;
use App\Observers\ProductsObserver;
use Illuminate\Support\Facades\View;
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

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::share('serviceState', ElsieServiceStateAction::make()->handle());
    }
}
