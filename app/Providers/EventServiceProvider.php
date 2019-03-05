<?php

namespace App\Providers;

use App\Events\ApplicantAddedToList;
use Illuminate\Auth\Events\Registered;
use App\Listeners\SendApplicantAddedToListNotification;
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

        ApplicantAddedToList::class => [
            SendApplicantAddedToListNotification::class
        ]


    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
