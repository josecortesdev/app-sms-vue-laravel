<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(\App\Services\SmsServiceInterface::class, function () {
            // Cambiar entre Altiria o Twilio según las necesidades
            if (env('SMS_PROVIDER') === 'altiria') {
                return new \App\Services\AltiriaSmsService();
            }
    
            return new \App\Services\TwilioSmsService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
