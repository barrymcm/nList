<?php

namespace App\Providers;

use App\Repositories\SlotRepository;
use Illuminate\Support\ServiceProvider;
use App\Services\EventService;
use App\Services\ApplicantService;
use App\Repositories\EventRepository;
use App\Services\ApplicantListService;
use App\Repositories\ApplicantRepository;
use App\Repositories\ApplicantListRepository;

class ServicesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ApplicantListService::class, function ($app) {
            return new ApplicantListService(
                new ApplicantListRepository($app->make('App\ApplicantList')),
                new SlotRepository($app->make('App\Slot'))
            );
        });

        $this->app->bind(ApplicantService::class, function ($app) {
            return new ApplicantService(new ApplicantRepository($app->make('App\Applicant')));
        });

        $this->app->bind(EventService::class, function ($app) {
            return new EventService(new EventRepository($app->make('App\Event')));
        });
    }
}
