<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        if (Schema::hasTable('settings')) {
            view()->composer('root.*', function($view) {
                $settings = DB::table('settings')
                    ->get()
                    ->keyBy('name')
                    ->map(function($item) {
                        return $item->value;
                    });

                $view->with(compact('settings'));
            });
        }
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
