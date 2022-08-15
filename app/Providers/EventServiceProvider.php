<?php

namespace App\Providers;

use App\Models\License;
use App\Models\Property;
use App\Observers\LicenseObserver;
use App\Observers\PropertyObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

use App\Events\ApiOPQueried;
use App\Events\RequestValidated;
use App\Listeners\APIPOAuthentication;
use App\Listeners\VerifyValidation;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        RequestValidated::class => [
            VerifyValidation::class,
        ],

        ApiOPQueried::class => [
            APIPOAuthentication::class,
        ],

    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Property::observe(PropertyObserver::class);
        License::observe(LicenseObserver::class);
    }
}
