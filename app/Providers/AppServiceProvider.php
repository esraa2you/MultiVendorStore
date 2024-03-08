<?php

namespace App\Providers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Validator;
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
        JsonResource::withoutWrapping();
        // The Macrous method
        //Deffine new rule and call it like traditinal rule
        Validator::extend(
            'filter',
            function ($attribute, $value, $params) {
                return !(in_array(strtolower($value), $params));
            },

            'this forbidden from AppServiceProvider'
        );
        Paginator::useBootstrap();
    }
}
