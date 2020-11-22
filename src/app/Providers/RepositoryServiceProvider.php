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
        $this->app->bind(RepositoryInterface::class, new ApplicantListRepository(new ApplicantList));
        $this->app->bind(RepositoryInterface::class, new ApplicantRepository(new Applicant));
        $this->app->bind(RepositoryInterface::class, new EventRepository(new Event));
        $this->app->bind(RepositoryInterface::class, new SlotRepository(new Slot));
        $this->app->bind(RepositoryInterface::class, new EventOrganiserRepository(new EventOrganiser));
        $this->app->bind(RepositoryInterface::class, new ApplicantContactDetailsRepository(new ApplicantContactDetails));
        $this->app->bind(RepositoryInterface::class, new UserRepository(new User));
        $this->app->bind(RepositoryInterface::class, new CustomerRepository(new Customer, new User));
        $this->app->bind(RepositoryInterface::class, new ApplicantApplicantListRepository(new ApplicantApplicantList));
    }
}
