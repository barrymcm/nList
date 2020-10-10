<?php

namespace App\Providers;

use App\Models\Customer;
use App\Models\ApplicantList;
use App\Models\Applicant;
use App\Policies\CustomerPolicy;
use App\Policies\ApplicantListPolicy;
use App\Policies\ApplicantPolicy;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Customer::class => CustomerPolicy::class,
        ApplicantList::class => ApplicantListPolicy::class,
        Applicant::class => ApplicantPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();
    }
}
