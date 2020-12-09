<?php

namespace App\Providers;

use App\Models\Slot;
use App\Models\User;
use App\Models\Event;
use App\Models\Customer;
use App\Models\Applicant;
use App\Models\EventOrganiser;
use App\Models\ApplicantList;
use App\Models\ApplicantApplicantList;
use App\Models\ApplicantContactDetails;
use App\Repositories\EventRepository;
use App\Repositories\UserRepository;
use App\Repositories\SlotRepository;
use App\Repositories\CustomerRepository;
use App\Repositories\ApplicantRepository;
use App\Repositories\RepositoryInterface;
use App\Repositories\EventOrganiserRepository;
use App\Repositories\ApplicantListRepository;
use App\Repositories\ApplicantApplicantListRepository;
use App\Repositories\ApplicantContactDetailsRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
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
        $this->app->bind(RepositoryInterface::class, function ($app) {
            return new ApplicantListRepository($app->make(ApplicantList::class));
        });

        $this->app->bind(RepositoryInterface::class, function ($app) {
            return new ApplicantRepository($app->make(Applicant::class));
        });

        $this->app->bind(RepositoryInterface::class, function ($app) {
            return new EventRepository($app->make(Event::class));
        });

        $this->app->bind(RepositoryInterface::class, function ($app) {
            return new SlotRepository($app->make(Slot::class));
        });
        $this->app->bind(RepositoryInterface::class, function ($app) {
            return new EventOrganiserRepository($app->make(EventOrganiser::class));
        });
        $this->app->bind(RepositoryInterface::class, function ($app) {
            return new ApplicantContactDetailsRepository($app->make(ApplicantContactDetails::class));
        });
        $this->app->bind(RepositoryInterface::class, function ($app) {
            return new UserRepository($app->make(User::class));
        });
        $this->app->bind(RepositoryInterface::class, function ($app) {
            return new CustomerRepository(new Customer, $app->make(User::class));
        });
        $this->app->bind(RepositoryInterface::class, function ($app) {
            return new ApplicantApplicantListRepository($app->make(ApplicantApplicantList::class));
        });
    }
}
