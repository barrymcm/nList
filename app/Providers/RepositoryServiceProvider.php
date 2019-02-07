<?php

namespace App\Providers;

use App\Models\ApplicantContactDetails;
use App\Models\Event;
use App\Models\Applicant;
use App\Models\Organiser;
use App\Models\Slot;
use App\Repositories\EventRepository;
use App\Repositories\ApplicantRepository;
use App\Repositories\OrganiserRepository;
use App\Repositories\RepositoryInterface;
use App\Repositories\SlotRepository;
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
        $this->app->bind(RepositoryInterface::class, new ApplicantRepository(new Applicant));
        $this->app->bind(RepositoryInterface::class, new EventRepository(new Event));
        $this->app->bind(RepositoryInterface::class, new SlotRepository(new Slot));
        $this->app->bind(RepositoryInterface::class, new OrganiserRepository(new Organiser));
    }
}
