<?php

namespace App\Providers;

use App\Models\Slot;
use App\Models\User;
use App\Models\Event;
use App\Models\Customer;
use App\Models\Applicant;
use App\Models\ApplicantList;
use App\Services\EventService;
use App\Services\CustomerService;
use App\Services\ApplicantService;
use App\Repositories\SlotRepository;
use App\Repositories\EventRepository;
use App\Models\ApplicantApplicantList;
use App\Services\ApplicantListService;
use Illuminate\Support\ServiceProvider;
use App\Repositories\CustomerRepository;
use App\Repositories\ApplicantRepository;
use App\Repositories\ApplicantListRepository;
use App\Repositories\ApplicantApplicantListRepository;
use App\Repositories\UserRepository;

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
                new ApplicantListRepository($app->make(ApplicantList::class)),
                new ApplicantApplicantListRepository($app->make(ApplicantApplicantList::class)),
                new SlotRepository($app->make(Slot::class)),
                new ApplicantRepository($app->make(Applicant::class))
            );
        });

        $this->app->bind(ApplicantService::class, function ($app) {
            return new ApplicantService(
                new ApplicantRepository($app->make(Applicant::class)),
                new CustomerRepository(
                    $app->make(Customer::class), 
                    $app->make(User::class)
                ),
                new UserRepository($app->make(User::class))
            );
        });

        $this->app->bind(EventService::class, function ($app) {
            return new EventService(new EventRepository($app->make(Event::class)));
        });

        $this->app->bind(CustomerService::class, function ($app) {
            return new CustomerService(
                new CustomerRepository($app->make(Customer::class), $app->make(User::class))
            );
        });
    }
}
