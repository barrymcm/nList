<?php

namespace App\Providers;

use App\Models\Customer;
use App\Models\ApplicantList;
use App\Models\Applicant;
use App\Models\Event;
use App\Models\EventOrganiser;
use App\Policies\CustomerPolicy;
use App\Policies\ApplicantListPolicy;
use App\Policies\ApplicantPolicy;
use App\Policies\EventPolicy;
use App\Policies\EventOrganiserPolicy;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Laravel\Passport\Passport;

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
        'App\Models\Event' => 'App\Policies\EventPolicy',
        'App\Models\EventOrganiser' => 'App\Policies\EventOrganiserPolicy',
    ];

    public function boot()
    {
        $this->registerPolicies();

        Gate::define('add', function (User $user) {
            
             return isset($user->customer)? $user->customer->is($user->customer) : false;
        });

        Gate::define('organiser-view', function (User $user) {
            $eventOrganiser = $user->eventOrganiser;
        
            return isset($eventOrganiser)? $eventOrganiser->user->is($user) : false;
        });

        Gate::define('update-list', function (User $user) {
            $eventOrganiser = $user->eventOrganiser;
        
            if (isset($eventOrganiser)) {
                return $eventOrganiser->user->is($user);
            }

            return false;
        });

        Passport::routes();
    }
}
