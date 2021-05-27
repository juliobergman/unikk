<?php

namespace App\Providers;

use App\Events\userCreated;
use App\Events\companyCreated;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Failed;
use Illuminate\Support\Facades\Event;
use App\Listeners\userCreatedListener;
use Illuminate\Auth\Events\Registered;
use App\Listeners\companyCreatedListener;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        userCreated::class => [
            userCreatedListener::class,
        ],
        companyCreated::class => [
            companyCreatedListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
