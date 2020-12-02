<?php

namespace App\Providers;

use App\Models\Customer;
use App\Models\User;
use App\Models\ApplicantList;
use App\Models\Applicant;
use App\Policies\CustomerPolicy;
use App\Policies\ApplicantListPolicy;
use App\Policies\ApplicantPolicy;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\Customer' => 'App\Policies\CustomerPolicy',
        'App\Models\ApplicantList' => 'App\Policies\ApplicantListPolicy',
        'App\Models\Applicant' => 'App\Policies\ApplicantPolicy',
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
