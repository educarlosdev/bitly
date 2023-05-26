<?php

namespace App\Providers;

use App\Models\Link;
use App\Models\PersonalAccessToken;
use App\Models\User;
use App\Observers\LinkObserver;
use App\Observers\UserObserver;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;

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
        Link::observe(LinkObserver::class);
        User::observe(UserObserver::class);
        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);
    }
}
