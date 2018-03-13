<?php

namespace App\Providers;

use App\Observers\QuestObserver;
use App\Observers\SettingObserver;
use App\Quest;
use App\Setting;
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
        Setting::observe(SettingObserver::class);
        Quest::observe(QuestObserver::class);
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
