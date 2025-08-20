<?php

namespace App\Providers;

use App\Models\TipeMobil;
use Cache;
use Carbon\Carbon;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $types = Cache::rememberForever('types', function () {
                return TipeMobil::all();
            });
            $view->with('types', $types);
        });
        Carbon::setLocale('id');
    }
}
