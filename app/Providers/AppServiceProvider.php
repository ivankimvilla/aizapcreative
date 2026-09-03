<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

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
        if ($this->app->runningInConsole()) {
            return;
        }

        $request = $this->app['request'];
        $forwardedProto = $request->header('x-forwarded-proto');

        if ($forwardedProto) {
            URL::forceScheme($forwardedProto);
        } elseif ($request->isSecure()) {
            URL::forceScheme('https');
        }

        $appUrl = config('app.url');
        if ($appUrl) {
            URL::forceRootUrl(rtrim($appUrl, '/'));
        } else {
            URL::forceRootUrl($request->getSchemeAndHttpHost());
        }
    }
}
