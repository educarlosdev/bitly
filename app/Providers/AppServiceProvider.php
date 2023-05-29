<?php

namespace App\Providers;

use App\Models\Link;
use App\Models\PersonalAccessToken;
use App\Models\User;
use App\Observers\LinkObserver;
use App\Observers\UserObserver;
use Illuminate\Routing\UrlGenerator;
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
    public function boot(UrlGenerator $url): void
    {
        if ($this->app->isProduction()) {
            //force https for assets and urls
            $url->forceScheme('https');
            //force https for pagination
            $this->app['request']->server->set('HTTPS', 'on');
        }

        Link::observe(LinkObserver::class);
        User::observe(UserObserver::class);
        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);
    }
}
