<?php

namespace App\Providers;

use App\Models\Applicant;
use App\Models\ApplicantList;
use App\Repositories\ApplicantRepository;
use App\Services\ApplicantService;
use Illuminate\Support\ServiceProvider;
use App\Services\ApplicantListService;

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
        $this->app->bind(ApplicantListService::class, function () {
            return new ApplicantListService(new ApplicantList());
        });

        $this->app->bind(ApplicantService::class, function ($app) {
            return new ApplicantService(new ApplicantRepository($app->make('App\Applicant')));
        });
    }
}
